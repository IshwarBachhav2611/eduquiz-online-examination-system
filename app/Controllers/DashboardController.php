<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;

class DashboardController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Examiner Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        // Check authentication
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $examinerId = session()->get('user_id');

        $examModel = new ExamModel();
        $questionModel = new QuestionModel();


        /*
        |--------------------------------------------------------------------------
        | Get Examiner's Examinations
        |--------------------------------------------------------------------------
        */

        $exams = $examModel
            ->where('examiner_id', $examinerId)
            ->orderBy('created_at', 'DESC')
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalExams = count($exams);

        $publishedExams = 0;

        $draftExams = 0;

        foreach ($exams as $exam) {

            if ($exam['status'] === 'Published') {

                $publishedExams++;

            }

            if ($exam['status'] === 'Draft') {

                $draftExams++;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Question Statistics
        |--------------------------------------------------------------------------
        */

        $totalQuestions = 0;

        $questionsCount = [];


        foreach ($exams as $exam) {

            $count = $questionModel
                ->where('exam_id', $exam['id'])
                ->countAllResults();

            $totalQuestions += $count;


            $questionsCount[] = [

                'exam_id' => $exam['id'],

                'total' => $count

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard Data
        |--------------------------------------------------------------------------
        */

        $data = [

            'exams' => $exams,

            'totalExams' => $totalExams,

            'publishedExams' => $publishedExams,

            'draftExams' => $draftExams,

            'totalQuestions' => $totalQuestions,

            'questionsCount' => $questionsCount

        ];


        return view(
            'dashboard/index',
            $data
        );
    }
}