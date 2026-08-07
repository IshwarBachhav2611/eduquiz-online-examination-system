<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\ExamModel;

class QuestionController extends BaseController
{
    protected $questionModel;

    protected $examModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();

        $this->examModel = new ExamModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Show Add Question Page
    |--------------------------------------------------------------------------
    */

    public function create($examId)
    {
        $exam = $this->examModel->find($examId);

        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        }

        return view('questions/create', [

            'exam' => $exam

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Save Question
    |--------------------------------------------------------------------------
    */

    public function store($examId)
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Edit Question
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Update Question
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Question
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {

    }
}