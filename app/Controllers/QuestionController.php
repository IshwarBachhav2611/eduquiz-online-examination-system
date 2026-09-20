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

    public function create($examId)
    {
        $exam = $this->examModel
            ->where('id', $examId)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $questions = $this->questionModel
            ->where('exam_id', $examId)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('questions/create', [
            'exam' => $exam,
            'questions' => $questions
        ]);
    }

    public function store($examId)
    {
        $exam = $this->examModel
            ->where('id', $examId)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $rules = [

            'question' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Please enter the question.',
                    'min_length' =>
                        'Question must contain at least 5 characters.'
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
                    'required' =>
                        'Please select the correct option.',
                    'in_list' =>
                        'Invalid correct option selected.'
                ]
            ],

            'marks' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Marks are required.',
                    'integer' => 'Marks must be a number.',
                    'greater_than' =>
                        'Marks must be greater than 0.'
                ]
            ]

        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

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

            'correct_option' =>
                $this->request->getPost('correct_option'),

            'marks' =>
                $this->request->getPost('marks')

        ];

        $this->questionModel->insert($questionData);

        return redirect()
            ->to('/questions/create/' . $examId)
            ->with(
                'success',
                'Question added successfully.'
            );
    }

    public function uploadCsv($examId)
    {
        $exam = $this->examModel
            ->where('id', $examId)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $file = $this->request->getFile('questions_csv');

        if (!$file || !$file->isValid()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select a valid CSV file.'
                );
        }

        if ($file->getClientExtension() !== 'csv') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Only CSV files are allowed.'
                );
        }

        $filePath = $file->getTempName();

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to read the uploaded CSV file.'
                );
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'The CSV file is empty.'
                );
        }

        $header = array_map(
            function ($value) {
                return strtolower(
                    trim(
                        preg_replace(
                            '/^\xEF\xBB\xBF/',
                            '',
                            $value
                        )
                    )
                );
            },
            $header
        );

        $requiredColumns = [
            'question',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_option',
            'marks'
        ];

        foreach ($requiredColumns as $column) {

            if (!in_array($column, $header, true)) {

                fclose($handle);

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Invalid CSV format. Missing column: ' .
                        $column
                    );
            }
        }

        $columnIndex = array_flip($header);

        $questions = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {

            $rowNumber++;

            if (
                count($row) === 1 &&
                trim($row[0]) === ''
            ) {
                continue;
            }

            $question = trim(
                $row[$columnIndex['question']] ?? ''
            );

            $optionA = trim(
                $row[$columnIndex['option_a']] ?? ''
            );

            $optionB = trim(
                $row[$columnIndex['option_b']] ?? ''
            );

            $optionC = trim(
                $row[$columnIndex['option_c']] ?? ''
            );

            $optionD = trim(
                $row[$columnIndex['option_d']] ?? ''
            );

            $correctOption = strtoupper(
                trim(
                    $row[$columnIndex['correct_option']] ?? ''
                )
            );

            $marks = trim(
                $row[$columnIndex['marks']] ?? ''
            );

            if ($question === '') {

                fclose($handle);

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Row ' . $rowNumber .
                        ': Question cannot be empty.'
                    );
            }

            if (
                $optionA === '' ||
                $optionB === '' ||
                $optionC === '' ||
                $optionD === ''
            ) {

                fclose($handle);

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Row ' . $rowNumber .
                        ': All four options are required.'
                    );
            }

            if (
                !in_array(
                    $correctOption,
                    ['A', 'B', 'C', 'D'],
                    true
                )
            ) {

                fclose($handle);

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Row ' . $rowNumber .
                        ': Correct option must be A, B, C or D.'
                    );
            }

            if (
                $marks === '' ||
                !is_numeric($marks) ||
                (int) $marks <= 0
            ) {

                fclose($handle);

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Row ' . $rowNumber .
                        ': Marks must be greater than 0.'
                    );
            }

            $questions[] = [

                'exam_id' => $examId,

                'question' => $question,

                'option_a' => $optionA,

                'option_b' => $optionB,

                'option_c' => $optionC,

                'option_d' => $optionD,

                'correct_option' => $correctOption,

                'marks' => (int) $marks

            ];
        }

        fclose($handle);

        if (empty($questions)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'No valid questions were found in the CSV file.'
                );
        }

        $db = \Config\Database::connect();

        $db->transStart();

        foreach ($questions as $question) {
            $this->questionModel->insert($question);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Failed to import questions. Please try again.'
                );
        }

        return redirect()
            ->to('/questions/create/' . $examId)
            ->with(
                'success',
                count($questions) .
                ' question(s) imported successfully from CSV.'
            );
    }

    public function edit($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $exam = $this->examModel
            ->where('id', $question['exam_id'])
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        return view('questions/edit', [
            'question' => $question,
            'exam' => $exam
        ]);
    }

    public function update($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $exam = $this->examModel
            ->where('id', $question['exam_id'])
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $rules = [
            'question' =>
                'required|min_length[3]',

            'option_a' =>
                'required',

            'option_b' =>
                'required',

            'option_c' =>
                'required',

            'option_d' =>
                'required',

            'correct_option' =>
                'required|in_list[A,B,C,D]',

            'marks' =>
                'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $questionData = [

            'question' =>
                trim(
                    $this->request->getPost('question')
                ),

            'option_a' =>
                trim(
                    $this->request->getPost('option_a')
                ),

            'option_b' =>
                trim(
                    $this->request->getPost('option_b')
                ),

            'option_c' =>
                trim(
                    $this->request->getPost('option_c')
                ),

            'option_d' =>
                trim(
                    $this->request->getPost('option_d')
                ),

            'correct_option' =>
                $this->request->getPost('correct_option'),

            'marks' =>
                $this->request->getPost('marks')
        ];

        $this->questionModel->update(
            $id,
            $questionData
        );

        return redirect()
            ->to(
                '/questions/create/' .
                $question['exam_id']
            )
            ->with(
                'success',
                'Question updated successfully.'
            );
    }

    public function delete($id)
    {
        $question = $this->questionModel->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $exam = $this->examModel
            ->where('id', $question['exam_id'])
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $examId = $question['exam_id'];

        $this->questionModel->delete($id);

        return redirect()
            ->to('/questions/create/' . $examId)
            ->with(
                'success',
                'Question deleted successfully.'
            );
    }
}