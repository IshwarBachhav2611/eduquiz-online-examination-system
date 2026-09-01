<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamStudentModel;
use App\Models\AttemptModel;

class StudentExamController extends BaseController
{
    protected $examModel;
    protected $questionModel;
    protected $examStudentModel;
    protected $attemptModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
        $this->questionModel = new QuestionModel();
        $this->examStudentModel = new ExamStudentModel();
        $this->attemptModel = new AttemptModel();
    }

    public function start($examId)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Logged-in Student
        |--------------------------------------------------------------------------
        */

        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as a student.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Examination
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
        | Get Questions
        |--------------------------------------------------------------------------
        */

        $questions = $this->questionModel
            ->where('exam_id', $examId)
            ->orderBy('id', 'ASC')
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Check Questions
        |--------------------------------------------------------------------------
        */

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
        | Create Attempt
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
        | Show Examination
        |--------------------------------------------------------------------------
        */

        return view('student_exam/start', [
            'exam'       => $exam,
            'questions'  => $questions,
            'attemptId'  => $attemptId
        ]);
    }
}