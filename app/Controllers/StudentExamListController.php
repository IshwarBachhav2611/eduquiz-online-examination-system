<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ExamStudentModel;

class StudentExamListController extends BaseController
{
    protected $examModel;
    protected $examStudentModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
        $this->examStudentModel = new ExamStudentModel();
    }

    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login first.');
        }

        $assignments = $this->examStudentModel
            ->where('student_id', $studentId)
            ->findAll();

        $exams = [];

        foreach ($assignments as $assignment) {

            $exam = $this->examModel
                ->where('id', $assignment['exam_id'])
                ->whereIn('status', ['Published', 'Active'])
                ->first();

            if ($exam) {
                $exams[] = $exam;
            }
        }

        return view('student/exams', [
            'exams' => $exams
        ]);
    }
}