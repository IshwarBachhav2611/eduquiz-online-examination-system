<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamStudentModel;
use App\Models\AttemptModel;
use App\Models\StudentAnswerModel;
use App\Models\ResultModel;

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

    public function start($examId)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Check student login
        |--------------------------------------------------------------------------
        */

        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | 2. Get examination
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
        | 3. Examination must be published
        |--------------------------------------------------------------------------
        */

        if ($exam['status'] !== 'Published') {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'This examination is not available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 4. Check whether this student is assigned
        |--------------------------------------------------------------------------
        */

        $assignment = $this->examStudentModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->first();

        if (!$assignment) {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'You are not assigned to this examination.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 5. Check existing attempt
        |--------------------------------------------------------------------------
        */

        $attempt = $this->attemptModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->orderBy('id', 'DESC')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | 6. Already completed?
        |--------------------------------------------------------------------------
        */

        if (
            $attempt &&
            in_array(
                $attempt['status'],
                ['Submitted', 'Auto Submitted'],
                true
            )
        ) {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'You have already completed this examination. A second attempt is not allowed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 7. Check examination schedule
        |--------------------------------------------------------------------------
        */

        $now = new \DateTime();

        $startDateTime = new \DateTime(
            $exam['exam_date'] . ' ' . $exam['start_time']
        );

        $endDateTime = new \DateTime(
            $exam['exam_date'] . ' ' . $exam['end_time']
        );


        /*
        |--------------------------------------------------------------------------
        | 8. Existing active attempt
        |--------------------------------------------------------------------------
        |
        | If the student has already started the examination,
        | don't create another attempt.
        |
        */

        if (
            $attempt &&
            $attempt['status'] === 'Started'
        ) {

            /*
            |--------------------------------------------------------------------------
            | Check whether the attempt has already exceeded its duration
            |--------------------------------------------------------------------------
            */

            $attemptStartTime = new \DateTime(
                $attempt['started_at']
            );

            $durationSeconds =
                ((int) $exam['duration']) * 60;

            $attemptEndTime =
                (clone $attemptStartTime)
                    ->modify('+' . $durationSeconds . ' seconds');


            /*
            |--------------------------------------------------------------------------
            | The effective end time is the earlier of:
            |
            | 1. Exam scheduled end time
            | 2. Attempt duration end time
            |--------------------------------------------------------------------------
            */

            $effectiveEndTime =
                ($attemptEndTime < $endDateTime)
                    ? $attemptEndTime
                    : $endDateTime;


            /*
            |--------------------------------------------------------------------------
            | Attempt expired
            |--------------------------------------------------------------------------
            */

            if ($now > $effectiveEndTime) {

                return redirect()
                    ->to('/student/exams')
                    ->with(
                        'error',
                        'The examination time has expired.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Resume existing attempt
            |--------------------------------------------------------------------------
            */

            $questions = $this->questionModel
                ->where('exam_id', $examId)
                ->orderBy('id', 'ASC')
                ->findAll();

            if (empty($questions)) {

                return redirect()
                    ->to('/student/exams')
                    ->with(
                        'error',
                        'This examination does not have any questions yet.'
                    );
            }


            return view('student_exam/start', [
                'exam'           => $exam,
                'questions'      => $questions,
                'attemptId'      => $attempt['id'],
                'attemptStarted' => $attempt['started_at'],
                'attemptEnd'     => $effectiveEndTime->format(
                    'Y-m-d H:i:s'
                )
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 9. Student has not started the exam yet
        |--------------------------------------------------------------------------
        |
        | Check whether the exam can currently be started.
        |--------------------------------------------------------------------------
        */

        if ($now < $startDateTime) {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'This examination has not started yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 10. Exam has already ended
        |--------------------------------------------------------------------------
        */

        if ($now > $endDateTime) {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'The examination time has expired.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 11. Get examination questions
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
        | 12. Create the student's ONE attempt
        |--------------------------------------------------------------------------
        */

        $attemptId = $this->attemptModel->insert([
            'exam_id'    => $examId,
            'student_id' => $studentId,
            'started_at' => date('Y-m-d H:i:s'),
            'status'     => 'Started'
        ], true);


        /*
        |--------------------------------------------------------------------------
        | 13. Calculate attempt end time
        |--------------------------------------------------------------------------
        */

        $attemptStartTime = new \DateTime();

        $durationSeconds =
            ((int) $exam['duration']) * 60;

        $attemptEndTime =
            (clone $attemptStartTime)
                ->modify('+' . $durationSeconds . ' seconds');


        /*
        |--------------------------------------------------------------------------
        | 14. Don't allow attempt to continue beyond exam end time
        |--------------------------------------------------------------------------
        */

        $effectiveEndTime =
            ($attemptEndTime < $endDateTime)
                ? $attemptEndTime
                : $endDateTime;


        /*
        |--------------------------------------------------------------------------
        | 15. Open examination
        |--------------------------------------------------------------------------
        */

        return view('student_exam/start', [
            'exam'           => $exam,
            'questions'      => $questions,
            'attemptId'      => $attemptId,
            'attemptStarted' => $attemptStartTime->format(
                'Y-m-d H:i:s'
            ),
            'attemptEnd'     => $effectiveEndTime->format(
                'Y-m-d H:i:s'
            )
        ]);
    }

    public function submit($attemptId)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Student Login
        |--------------------------------------------------------------------------
        */

        $studentId = session('student_id');

        if (!$studentId) {

            return redirect()
                ->to('/student/login')
                ->with(
                    'error',
                    'Please login as a student.'
                );
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
        |
        | If the examination has already been submitted,
        | do not evaluate it again.
        |
        */

        if (
            in_array(
                $attempt['status'],
                ['Submitted', 'Auto Submitted'],
                true
            )
        ) {

            return redirect()
                ->to('/student/exam/result/' . $attemptId)
                ->with(
                    'error',
                    'This examination has already been submitted.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Only Started Attempts Can Be Submitted
        |--------------------------------------------------------------------------
        */

        if ($attempt['status'] !== 'Started') {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'This examination attempt is not valid.'
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
                ->to('/student/exams')
                ->with(
                    'error',
                    'This examination does not contain any questions.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | India Timezone
        |--------------------------------------------------------------------------
        */

        $timezone = new \DateTimeZone(
            'Asia/Kolkata'
        );


        /*
        |--------------------------------------------------------------------------
        | Current Server Time
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | This is server-side time.
        | We do NOT trust the browser timer.
        |
        */

        $now = new \DateTime(
            'now',
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | Attempt Start Time
        |--------------------------------------------------------------------------
        */

        $attemptStartedAt = new \DateTime(
            $attempt['started_at'],
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | Calculate Duration-Based End Time
        |--------------------------------------------------------------------------
        */

        $durationMinutes = (int) $exam['duration'];

        $attemptEnd = clone $attemptStartedAt;

        $attemptEnd->modify(
            '+' . $durationMinutes . ' minutes'
        );


        /*
        |--------------------------------------------------------------------------
        | Calculate Scheduled Examination End
        |--------------------------------------------------------------------------
        */

        $examEnd = new \DateTime(
            $exam['exam_date'] . ' ' . $exam['end_time'],
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | Actual Allowed End Time
        |--------------------------------------------------------------------------
        |
        | Student must stop at whichever comes first:
        |
        | 1. Attempt duration expires
        | 2. Scheduled examination ends
        |
        */

        if ($examEnd < $attemptEnd) {

            $allowedEnd = $examEnd;

        } else {

            $allowedEnd = $attemptEnd;
        }


        /*
        |--------------------------------------------------------------------------
        | Determine Whether Submission Is Late
        |--------------------------------------------------------------------------
        */

        $isExpired = $now > $allowedEnd;


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
        | Start Database Transaction
        |--------------------------------------------------------------------------
        |
        | Evaluation, answers, attempt update and result creation
        | must succeed together.
        |
        */

        $db = \Config\Database::connect();

        $db->transBegin();


        try {

            /*
            |--------------------------------------------------------------------------
            | Calculate Score
            |--------------------------------------------------------------------------
            */

            $totalScore = 0;


            foreach ($questions as $question) {

                $questionId = $question['id'];


                /*
                |--------------------------------------------------------------------------
                | Get Selected Answer
                |--------------------------------------------------------------------------
                */

                $selectedOption =
                    $answers[$questionId] ?? null;


                /*
                |--------------------------------------------------------------------------
                | Validate Submitted Option
                |--------------------------------------------------------------------------
                */

                if (
                    $selectedOption !== null &&
                    !in_array(
                        $selectedOption,
                        ['A', 'B', 'C', 'D'],
                        true
                    )
                ) {

                    $selectedOption = null;
                }


                /*
                |--------------------------------------------------------------------------
                | Determine Correctness
                |--------------------------------------------------------------------------
                */

                $isCorrect = false;

                $marksObtained = 0;


                if ($selectedOption !== null) {

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
                | Store Student Answer
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


            $percentage =
                $totalMarks > 0
                    ? round(
                        ($totalScore / $totalMarks) * 100,
                        2
                    )
                    : 0;


            /*
            |--------------------------------------------------------------------------
            | Determine Pass / Fail
            |--------------------------------------------------------------------------
            */

            $resultStatus =
                $totalScore >=
                (int) $exam['passing_marks']
                    ? 'Pass'
                    : 'Fail';


            /*
            |--------------------------------------------------------------------------
            | Submission Status
            |--------------------------------------------------------------------------
            |
            | Normal submission:
            | Submitted
            |
            | Time expired:
            | Auto Submitted
            |
            */

            $submissionStatus =
                $isExpired
                    ? 'Auto Submitted'
                    : 'Submitted';


            /*
            |--------------------------------------------------------------------------
            | Submission Time
            |--------------------------------------------------------------------------
            */

            $submittedAt =
                $now->format(
                    'Y-m-d H:i:s'
                );


            /*
            |--------------------------------------------------------------------------
            | Update Attempt
            |--------------------------------------------------------------------------
            */

            $updated =
                $this->attemptModel->update(

                    $attemptId,

                    [

                        'score' =>
                            $totalScore,

                        'percentage' =>
                            $percentage,

                        'submitted_at' =>
                            $submittedAt,

                        'status' =>
                            $submissionStatus

                    ]
                );


            if (!$updated) {

                throw new \RuntimeException(
                    'Unable to update examination attempt.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Check Existing Result
            |--------------------------------------------------------------------------
            |
            | Prevent duplicate result records.
            |
            */

            $existingResult =
                $this->resultModel
                    ->where(
                        'attempt_id',
                        $attemptId
                    )
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Create Result Only If It Does Not Exist
            |--------------------------------------------------------------------------
            */

            if (!$existingResult) {

                $resultInserted =
                    $this->resultModel->insert([

                        'attempt_id' =>
                            $attemptId,

                        'rank' =>
                            0,

                        'status' =>
                            $resultStatus,

                        'published_at' =>
                            $submittedAt

                    ]);


                if (!$resultInserted) {

                    throw new \RuntimeException(
                        'Unable to create examination result.'
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Verify Transaction
            |--------------------------------------------------------------------------
            */

            if ($db->transStatus() === false) {

                throw new \RuntimeException(
                    'Database transaction failed.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Commit Transaction
            |--------------------------------------------------------------------------
            */

            $db->transCommit();


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Rollback
            |--------------------------------------------------------------------------
            */

            $db->transRollback();


            /*
            |--------------------------------------------------------------------------
            | Log Error
            |--------------------------------------------------------------------------
            */

            log_message(
                'error',
                'Exam submission failed for attempt {attemptId}: {message}',
                [
                    'attemptId' => $attemptId,
                    'message' => $e->getMessage()
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Return Error
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'Unable to submit the examination. Please try again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Submission Message
        |--------------------------------------------------------------------------
        */

        if ($isExpired) {

            $message =
                'Time expired. Your examination was automatically submitted.';

        } else {

            $message =
                'Examination submitted successfully.';
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect to Result
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/student/exam/result/' . $attemptId)
            ->with(
                'success',
                $message
            );
    }

    public function result($attemptId)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Student Login
        |--------------------------------------------------------------------------
        */

        $studentId = session('student_id');

        if (!$studentId) {

            return redirect()
                ->to('/student/login')
                ->with(
                    'error',
                    'Please login as a student.'
                );
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
        | Result is available only after submission
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $attempt['status'],
                ['Submitted', 'Auto Submitted'],
                true
            )
        ) {

            return redirect()
                ->to('/student/exams')
                ->with(
                    'error',
                    'This examination has not been submitted yet.'
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

        $studentAnswers = $this->studentAnswerModel
            ->where('attempt_id', $attemptId)
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Create question => answer lookup
        |--------------------------------------------------------------------------
        */

        $answersByQuestion = [];


        foreach ($studentAnswers as $studentAnswer) {

            $answersByQuestion[
                $studentAnswer['question_id']
            ] = $studentAnswer;
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Answer Summary
        |--------------------------------------------------------------------------
        */

        $correctCount = 0;
        $wrongCount = 0;
        $notAnsweredCount = 0;


        foreach ($questions as $question) {

            $questionId = $question['id'];


            if (!isset($answersByQuestion[$questionId])) {

                $notAnsweredCount++;

                continue;
            }


            $answer =
                $answersByQuestion[$questionId];


            if (
                $answer['selected_option'] === null ||
                $answer['selected_option'] === ''
            ) {

                $notAnsweredCount++;

            } elseif (
                (int) $answer['is_correct'] === 1
            ) {

                $correctCount++;

            } else {

                $wrongCount++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Return Result Page
        |--------------------------------------------------------------------------
        */

        return view('student_exam/result', [

            'attempt' => $attempt,

            'exam' => $exam,

            'result' => $result,

            'questions' => $questions,

            'answersByQuestion' => $answersByQuestion,

            'correctCount' => $correctCount,

            'wrongCount' => $wrongCount,

            'notAnsweredCount' => $notAnsweredCount

        ]);
    }
}