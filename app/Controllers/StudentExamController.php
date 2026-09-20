<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamStudentModel;
use App\Models\AttemptModel;
use App\Models\StudentAnswerModel;
use App\Models\ResultModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class StudentExamController extends BaseController
{
    protected $examModel;
    protected $questionModel;
    protected $examStudentModel;
    protected $attemptModel;
    protected $studentAnswerModel;
    protected $resultModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
        $this->questionModel = new QuestionModel();
        $this->examStudentModel = new ExamStudentModel();
        $this->attemptModel = new AttemptModel();
        $this->studentAnswerModel = new StudentAnswerModel();
        $this->resultModel = new ResultModel();
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW EXAMINATION CONFIRMATION
    |--------------------------------------------------------------------------
    |
    | This method DOES NOT create an attempt.
    |
    | Student clicks "Start Exam"
    |          ↓
    | This method opens confirmation page
    |          ↓
    | Student reads description/instructions
    |
    */

    public function start($examId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Examination
        |--------------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Check Student Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = $this->examStudentModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->first();

        if (!$assignment) {
            return redirect()
                ->to('/dashboard')
                ->with(
                    'error',
                    'You are not assigned to this examination.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Questions
        |--------------------------------------------------------------------------
        */

        $questionCount = $this->questionModel
            ->where('exam_id', $examId)
            ->countAllResults();

        if ($questionCount === 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This examination does not have any questions yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Existing Attempt
        |--------------------------------------------------------------------------
        |
        | A student is allowed to take an examination only once.
        |
        | Started attempt  → Continue existing attempt
        | Submitted attempt → View result
        |
        */

        $existingAttempt = $this->attemptModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->orderBy('id', 'DESC')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Already Submitted
        |--------------------------------------------------------------------------
        */

        if ($existingAttempt) {

            if ($existingAttempt['status'] === 'Submitted') {

                return redirect()
                    ->to(
                        '/student/exam/result/'
                        . $existingAttempt['id']
                    )
                    ->with(
                        'error',
                        'You have already completed this examination.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Existing Active Attempt
            |--------------------------------------------------------------------------
            |
            | Do not create another attempt.
            | Allow the student to continue the same examination.
            |
            */

            if ($existingAttempt['status'] === 'Started') {

                return redirect()
                    ->to(
                        '/student/exam/attempt/'
                        . $existingAttempt['id']
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Show Confirmation Page
        |--------------------------------------------------------------------------
        */

        return view('student_exam/confirm', [

            'exam' => $exam,

            'questionCount' => $questionCount

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | BEGIN EXAMINATION
    |--------------------------------------------------------------------------
    |
    | This method is called only after the student confirms:
    |
    | "I Understand & Start Examination"
    |
    | This is where the actual attempt is created.
    |
    */

    public function begin($examId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Examination
        |--------------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Check Student Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = $this->examStudentModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->first();

        if (!$assignment) {
            return redirect()
                ->to('/dashboard')
                ->with(
                    'error',
                    'You are not assigned to this examination.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Questions
        |--------------------------------------------------------------------------
        */

        $questions = $this->questionModel
            ->where('exam_id', $examId)
            ->orderBy('id', 'ASC')
            ->findAll();

        if (empty($questions)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This examination does not have any questions yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Existing Attempt
        |--------------------------------------------------------------------------
        |
        | Important:
        | Even if the student tries to submit the confirmation form twice,
        | we must NEVER create a second attempt.
        |
        */

        $existingAttempt = $this->attemptModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->orderBy('id', 'DESC')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Already Submitted
        |--------------------------------------------------------------------------
        */

        if ($existingAttempt) {

            if ($existingAttempt['status'] === 'Submitted') {

                return redirect()
                    ->to(
                        '/student/exam/result/'
                        . $existingAttempt['id']
                    )
                    ->with(
                        'error',
                        'You have already completed this examination.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Already Started
            |--------------------------------------------------------------------------
            */

            if ($existingAttempt['status'] === 'Started') {

                return redirect()
                    ->to(
                        '/student/exam/attempt/'
                        . $existingAttempt['id']
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create New Attempt
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | The timer starts here.
        |
        | NOT when the student clicks "Start Exam" on My Exams.
        |
        */

        $startedAt = date('Y-m-d H:i:s');

        $attemptId = $this->attemptModel->insert([

            'exam_id'    => $examId,

            'student_id' => $studentId,

            'started_at' => $startedAt,

            'status'     => 'Started'

        ], true);


        /*
        |--------------------------------------------------------------------------
        | Calculate Examination End Time
        |--------------------------------------------------------------------------
        */

        $durationMinutes = (int) $exam['duration'];

        $attemptEndTimestamp =
            strtotime($startedAt)
            + ($durationMinutes * 60);

        $attemptEnd = date(
            'Y-m-d H:i:s',
            $attemptEndTimestamp
        );


        /*
        |--------------------------------------------------------------------------
        | Open Examination
        |--------------------------------------------------------------------------
        */

        return view('student_exam/start', [

            'exam' => $exam,

            'questions' => $questions,

            'attemptId' => $attemptId,

            'attemptEnd' => $attemptEnd

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | OPEN EXISTING ATTEMPT
    |--------------------------------------------------------------------------
    |
    | Used when:
    |
    | Continue Exam
    |
    | Student refreshes the page
    |
    | Student returns to an unfinished examination
    |
    */

    public function attempt($attemptId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Attempt
        |--------------------------------------------------------------------------
        */

        $attempt = $this->attemptModel
            ->where('id', $attemptId)
            ->where('student_id', $studentId)
            ->first();

        if (!$attempt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Opening Submitted Attempt
        |--------------------------------------------------------------------------
        */

        if ($attempt['status'] !== 'Started') {

            return redirect()
                ->to('/student/exam/result/' . $attemptId)
                ->with(
                    'error',
                    'This examination has already been submitted.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Examination
        |--------------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Get Questions
        |--------------------------------------------------------------------------
        */

        $questions = $this->questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();

        if (empty($questions)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This examination does not have any questions.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Original End Time
        |--------------------------------------------------------------------------
        |
        | We calculate the end time from:
        |
        | started_at + duration
        |
        | This means refreshing the page does NOT reset the timer.
        |
        */

        $startedTimestamp = strtotime($attempt['started_at']);

        $durationMinutes = (int) $exam['duration'];

        $attemptEndTimestamp =
            $startedTimestamp
            + ($durationMinutes * 60);

        $attemptEnd = date(
            'Y-m-d H:i:s',
            $attemptEndTimestamp
        );


        /*
        |--------------------------------------------------------------------------
        | Show Examination
        |--------------------------------------------------------------------------
        */

        return view('student_exam/start', [

            'exam' => $exam,

            'questions' => $questions,

            'attemptId' => $attemptId,

            'attemptEnd' => $attemptEnd

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT EXAM
    |--------------------------------------------------------------------------
    */

    public function submit($attemptId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Attempt
        |--------------------------------------------------------------------------
        */

        $attempt = $this->attemptModel
            ->where('id', $attemptId)
            ->where('student_id', $studentId)
            ->first();

        if (!$attempt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Submission
        |--------------------------------------------------------------------------
        */

        if ($attempt['status'] !== 'Started') {

            return redirect()
                ->to('/student/exam/result/' . $attemptId)
                ->with(
                    'error',
                    'This examination has already been submitted.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Exam
        |--------------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Get Questions
        |--------------------------------------------------------------------------
        */

        $questions = $this->questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Get Submitted Answers
        |--------------------------------------------------------------------------
        */

        $answers = $this->request->getPost('answers');

        if (!is_array($answers)) {
            $answers = [];
        }


        /*
        |--------------------------------------------------------------------------
        | Evaluate Answers
        |--------------------------------------------------------------------------
        */

        $totalScore = 0;

        foreach ($questions as $question) {

            $questionId = $question['id'];

            $selectedOption =
                $answers[$questionId] ?? null;

            $isCorrect = false;

            $marksObtained = 0;


            /*
            |--------------------------------------------------------------------------
            | Check Answer
            |--------------------------------------------------------------------------
            */

            if (
                $selectedOption !== null &&
                in_array(
                    $selectedOption,
                    ['A', 'B', 'C', 'D']
                )
            ) {

                if (
                    $selectedOption ===
                    $question['correct_option']
                ) {

                    $isCorrect = true;

                    $marksObtained =
                        (int) $question['marks'];

                    $totalScore += $marksObtained;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Save Student Answer
            |--------------------------------------------------------------------------
            */

            $this->studentAnswerModel->insert([

                'attempt_id' =>
                    $attemptId,

                'question_id' =>
                    $questionId,

                'selected_option' =>
                    $selectedOption,

                'is_correct' =>
                    $isCorrect,

                'marks_obtained' =>
                    $marksObtained

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Percentage
        |--------------------------------------------------------------------------
        */

        $totalMarks =
            (int) $exam['total_marks'];

        if ($totalMarks > 0) {

            $percentage = round(
                ($totalScore / $totalMarks) * 100,
                2
            );

        } else {

            $percentage = 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Pass / Fail
        |--------------------------------------------------------------------------
        */

        $resultStatus =
            $totalScore >=
            (int) $exam['passing_marks']
                ? 'Pass'
                : 'Fail';


        /*
        |--------------------------------------------------------------------------
        | Update Attempt
        |--------------------------------------------------------------------------
        */

        $this->attemptModel->update(

            $attemptId,

            [

                'score' =>
                    $totalScore,

                'percentage' =>
                    $percentage,

                'submitted_at' =>
                    date('Y-m-d H:i:s'),

                'status' =>
                    'Submitted'

            ]

        );


        /*
        |--------------------------------------------------------------------------
        | Create Result
        |--------------------------------------------------------------------------
        */

        $this->resultModel->insert([

            'attempt_id' =>
                $attemptId,

            'rank' =>
                0,

            'status' =>
                $resultStatus,

            'published_at' =>
                date('Y-m-d H:i:s')

        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect To Result
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to(
                '/student/exam/result/'
                . $attemptId
            )
            ->with(
                'success',
                'Examination submitted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW RESULT
    |--------------------------------------------------------------------------
    */

    public function result($attemptId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Attempt
        |--------------------------------------------------------------------------
        */

        $attempt = $this->attemptModel
            ->where('id', $attemptId)
            ->where('student_id', $studentId)
            ->first();

        if (!$attempt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Get Examination
        |--------------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Get Result
        |--------------------------------------------------------------------------
        */

        $result = $this->resultModel
            ->where('attempt_id', $attemptId)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Get Questions
        |--------------------------------------------------------------------------
        */

        $questions = $this->questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Get Student Answers
        |--------------------------------------------------------------------------
        */

        $answers = $this->studentAnswerModel
            ->where('attempt_id', $attemptId)
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Create Question ID => Answer Mapping
        |--------------------------------------------------------------------------
        |
        | This is important because the result view uses:
        |
        | $answersByQuestion[$questionId]
        |
        */

        $answersByQuestion = [];

        foreach ($answers as $answer) {

            $answersByQuestion[
                $answer['question_id']
            ] = $answer;

        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Statistics
        |--------------------------------------------------------------------------
        */

        $correctCount = 0;

        $wrongCount = 0;

        $answeredCount = 0;


        foreach ($answers as $answer) {

            $selectedOption =
                $answer['selected_option'] ?? null;


            if (
                $selectedOption !== null &&
                $selectedOption !== ''
            ) {

                $answeredCount++;


                if (
                    isset($answer['is_correct']) &&
                    (
                        $answer['is_correct'] === true ||
                        $answer['is_correct'] === 1 ||
                        $answer['is_correct'] === '1'
                    )
                ) {

                    $correctCount++;

                } else {

                    $wrongCount++;

                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Not Answered
        |--------------------------------------------------------------------------
        */

        $totalQuestions = count($questions);

        $notAnsweredCount = max(
            0,
            $totalQuestions - $answeredCount
        );


        /*
        |--------------------------------------------------------------------------
        | Percentage
        |--------------------------------------------------------------------------
        */

        $percentage = 0;

        if ((int) $exam['total_marks'] > 0) {

            $percentage = round(

                (
                    ((float) $attempt['score'])
                    / (int) $exam['total_marks']
                ) * 100,

                2

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pass / Fail
        |--------------------------------------------------------------------------
        */

        $status = 'Fail';

        if (
            (float) $attempt['score']
            >= (int) $exam['passing_marks']
        ) {

            $status = 'Pass';

        }


        /*
        |--------------------------------------------------------------------------
        | Result View
        |--------------------------------------------------------------------------
        */

        return view(
            'student_exam/result',
            [

                'attempt' => $attempt,

                'exam' => $exam,

                'result' => $result,

                'questions' => $questions,

                'answers' => $answers,

                /*
                | Important:
                | The result view needs this variable.
                */

                'answersByQuestion' => $answersByQuestion,

                'totalQuestions' => $totalQuestions,

                'answeredCount' => $answeredCount,

                'correctCount' => $correctCount,

                'wrongCount' => $wrongCount,

                'notAnsweredCount' => $notAnsweredCount,

                'unansweredCount' => $notAnsweredCount,

                'percentage' => $percentage,

                'status' => $status

            ]
        );
    }

    public function downloadResult($attemptId)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login as a student.');
        }

        $attempt = $this->attemptModel
            ->where('id', $attemptId)
            ->where('student_id', $studentId)
            ->first();

        if (!$attempt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $studentModel = new \App\Models\StudentModel();

        $student = $studentModel
            ->where('id', $studentId)
            ->first();

        $questions = $this->questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();

        $answers = $this->studentAnswerModel
            ->where('attempt_id', $attemptId)
            ->findAll();

        $correctCount = 0;
        $wrongCount = 0;
        $answeredCount = 0;

        foreach ($answers as $answer) {

            if (
                isset($answer['selected_option']) &&
                $answer['selected_option'] !== null &&
                $answer['selected_option'] !== ''
            ) {
                $answeredCount++;

                if (
                    isset($answer['is_correct']) &&
                    (
                        $answer['is_correct'] === true ||
                        $answer['is_correct'] === 1 ||
                        $answer['is_correct'] === '1'
                    )
                ) {
                    $correctCount++;
                } else {
                    $wrongCount++;
                }
            }
        }

        $totalQuestions = count($questions);

        $notAnsweredCount = max(
            0,
            $totalQuestions - $answeredCount
        );

        $totalMarks = (float) $exam['total_marks'];
        $score = (float) ($attempt['score'] ?? 0);

        $percentage = 0;

        if ($totalMarks > 0) {
            $percentage = round(
                ($score / $totalMarks) * 100,
                2
            );
        }

        $status = 'FAIL';

        if (
            $score >= (float) $exam['passing_marks']
        ) {
            $status = 'PASS';
        }

        $studentName = $student['name']
            ?? $student['full_name']
            ?? 'Student';

        $studentEmail = $student['email']
            ?? '';

        $html = view('student_exam/result_pdf', [
            'studentName' => $studentName,
            'studentEmail' => $studentEmail,
            'exam' => $exam,
            'attempt' => $attempt,
            'totalQuestions' => $totalQuestions,
            'answeredCount' => $answeredCount,
            'correctCount' => $correctCount,
            'wrongCount' => $wrongCount,
            'notAnsweredCount' => $notAnsweredCount,
            'score' => $score,
            'percentage' => $percentage,
            'status' => $status
        ]);

        $options = new Options();

        $options->set(
            'isHtml5ParserEnabled',
            true
        );

        $options->set(
            'isRemoteEnabled',
            true
        );

        $options->set(
            'defaultFont',
            'DejaVu Sans'
        );

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper(
            'A4',
            'portrait'
        );

        $dompdf->render();

        $fileName = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $exam['title']
        );

        $fileName .= '_Result.pdf';

        $dompdf->stream(
            $fileName,
            [
                'Attachment' => true
            ]
        );

        exit;
    }
}