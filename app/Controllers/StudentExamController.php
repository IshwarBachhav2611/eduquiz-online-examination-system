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
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login as a student.');
        }

        $exam = $this->examModel
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

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

        $attemptId = $this->attemptModel->insert([
            'exam_id'    => $examId,
            'student_id' => $studentId,
            'started_at' => date('Y-m-d H:i:s'),
            'status'     => 'Started'
        ], true);

        return view('student_exam/start', [
            'exam'      => $exam,
            'questions' => $questions,
            'attemptId' => $attemptId
        ]);
    }

    public function submit($attemptId)
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

        if ($attempt['status'] !== 'Started') {
            return redirect()
                ->to('/student/exam/result/' . $attemptId)
                ->with(
                    'error',
                    'This examination has already been submitted.'
                );
        }

        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $questions = $this->questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();

        $answers = $this->request->getPost('answers');

        if (!is_array($answers)) {
            $answers = [];
        }

        $totalScore = 0;

        foreach ($questions as $question) {

            $questionId = $question['id'];

            $selectedOption = $answers[$questionId] ?? null;

            $isCorrect = false;

            $marksObtained = 0;

            if (
                $selectedOption !== null &&
                in_array($selectedOption, ['A', 'B', 'C', 'D'], true)
            ) {
                if ($selectedOption === $question['correct_option']) {
                    $isCorrect = true;
                    $marksObtained = (int) $question['marks'];
                    $totalScore += $marksObtained;
                }
            }

            $this->studentAnswerModel->insert([
                'attempt_id'      => $attemptId,
                'question_id'     => $questionId,
                'selected_option' => $selectedOption,
                'is_correct'      => $isCorrect,
                'marks_obtained'  => $marksObtained
            ]);
        }

        $totalMarks = (int) $exam['total_marks'];

        $percentage = $totalMarks > 0
            ? round(($totalScore / $totalMarks) * 100, 2)
            : 0;

        $resultStatus = $totalScore >= (int) $exam['passing_marks']
            ? 'Pass'
            : 'Fail';

        $this->attemptModel->update(
            $attemptId,
            [
                'score'        => $totalScore,
                'percentage'   => $percentage,
                'submitted_at' => date('Y-m-d H:i:s'),
                'status'       => 'Submitted'
            ]
        );

        $this->resultModel->insert([
            'attempt_id'   => $attemptId,
            'rank'         => 0,
            'status'       => $resultStatus,
            'published_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()
            ->to('/student/exam/result/' . $attemptId)
            ->with(
                'success',
                'Examination submitted successfully.'
            );
    }

    public function result($attemptId)
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

        $result = $this->resultModel
            ->where('attempt_id', $attemptId)
            ->first();

        return view('student_exam/result', [
            'attempt' => $attempt,
            'exam'    => $exam,
            'result'  => $result
        ]);
    }
}