<?php

namespace App\Controllers;

use App\Models\ExamModel;

class ExamController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Create Examination Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('exams/create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Examination
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $rules = [

            'title' => 'required|min_length[3]|max_length[255]',

            'subject' => 'required|max_length[150]',

            'duration' => 'required|integer|greater_than[0]',

            'total_marks' => 'required|integer|greater_than[0]',

            'passing_marks' => 'required|integer|greater_than_equal_to[0]',

            'exam_date' => 'required',

            'start_time' => 'required',

            'end_time' => 'required'

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());

        }

        $examModel = new ExamModel();

        $action = $this->request->getPost('action');

        $status = ($action == 'draft') ? 'Draft' : 'Published';

        $examData = [

            'examiner_id' => session('user_id'),

            'title' => trim($this->request->getPost('title')),

            'subject' => trim($this->request->getPost('subject')),

            'description' => trim($this->request->getPost('description')),

            'instructions' => trim($this->request->getPost('instructions')),

            'duration' => $this->request->getPost('duration'),

            'total_marks' => $this->request->getPost('total_marks'),

            'passing_marks' => $this->request->getPost('passing_marks'),

            'max_attempts' => $this->request->getPost('max_attempts'),

            'negative_marking' => $this->request->getPost('negative_marking'),

            'exam_date' => $this->request->getPost('exam_date'),

            'start_time' => $this->request->getPost('start_time'),

            'end_time' => $this->request->getPost('end_time'),

            'status' => $status

        ];

        $examModel->insert($examData);

        $examId = $examModel->getInsertID();

        if ($action == 'draft') {

            return redirect()->to('/dashboard')
                ->with('success', 'Examination saved as draft successfully.');

        }

        return redirect()->to('/questions/create/' . $examId)
            ->with('success', 'Examination created successfully. Now add questions.');
    }

    /*
    |--------------------------------------------------------------------------
    | List Examinations
    |--------------------------------------------------------------------------
    */

    public function index()
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Edit Examination
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Update Examination
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Examination
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {

    }
}