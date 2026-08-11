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

        // Get all questions belonging to this examination
        $questions = $this->questionModel
            ->where('exam_id', $examId)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('questions/create', [
            'exam' => $exam,
            'questions' => $questions
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Save Question
    |--------------------------------------------------------------------------
    */

    public function store($examId)
    {
        // Check whether exam exists
        $exam = $this->examModel->find($examId);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        // Validation rules
        $rules = [

            'question' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Please enter the question.',
                    'min_length' => 'Question must contain at least 5 characters.'
                ]
            ],

            'option_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Option A is required.'
                ]
            ],

            'option_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Option B is required.'
                ]
            ],

            'option_c' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Option C is required.'
                ]
            ],

            'option_d' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Option D is required.'
                ]
            ],

            'correct_option' => [
                'rules' => 'required|in_list[A,B,C,D]',
                'errors' => [
                    'required' => 'Please select the correct option.',
                    'in_list' => 'Invalid correct option selected.'
                ]
            ],

            'marks' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Marks are required.',
                    'integer' => 'Marks must be a number.',
                    'greater_than' => 'Marks must be greater than 0.'
                ]
            ]

        ];


        // Validate
        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        // Prepare question data
        $questionData = [

            'exam_id' => $examId,

            'question' => trim(
                $this->request->getPost('question')
            ),

            'option_a' => trim(
                $this->request->getPost('option_a')
            ),

            'option_b' => trim(
                $this->request->getPost('option_b')
            ),

            'option_c' => trim(
                $this->request->getPost('option_c')
            ),

            'option_d' => trim(
                $this->request->getPost('option_d')
            ),

            'correct_option' => $this->request->getPost('correct_option'),

            'marks' => $this->request->getPost('marks')

        ];


        // Save question
        $this->questionModel->insert($questionData);


        return redirect()
            ->to('/questions/create/' . $examId)
            ->with('success', 'Question added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Question
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $exam = $this->examModel->find($question['exam_id']);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('questions/edit', [
            'question' => $question,
            'exam'     => $exam
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update Question
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'question'    => 'required|min_length[3]',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in_list[A,B,C,D]',
            'marks' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $questionData = [
            'question'       => trim($this->request->getPost('question')),
            'option_a'       => trim($this->request->getPost('option_a')),
            'option_b'       => trim($this->request->getPost('option_b')),
            'option_c'       => trim($this->request->getPost('option_c')),
            'option_d'       => trim($this->request->getPost('option_d')),
            'correct_option' => $this->request->getPost('correct_option'),
            'marks'          => $this->request->getPost('marks')
        ];

        $this->questionModel->update($id, $questionData);

        return redirect()
            ->to('/questions/create/' . $question['exam_id'])
            ->with('success', 'Question updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Question
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $examId = $question['exam_id'];

        $this->questionModel->delete($id);

        return redirect()
            ->to('/questions/create/' . $examId)
            ->with('success', 'Question deleted successfully.');
    }

}