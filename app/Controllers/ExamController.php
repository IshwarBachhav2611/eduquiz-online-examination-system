<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;

use App\Models\StudentModel;
use App\Models\ExamStudentModel;

class ExamController extends BaseController
{
    protected $examModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
    }


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


        $action = $this->request->getPost('action');

        $status = ($action === 'draft')
            ? 'Draft'
            : 'Published';


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


        $this->examModel->insert($examData);

        $examId = $this->examModel->getInsertID();


        if ($action === 'draft') {

            return redirect()->to('/dashboard')
                ->with(
                    'success',
                    'Examination saved as draft successfully.'
                );
        }


        return redirect()
            ->to('/questions/create/' . $examId)
            ->with(
                'success',
                'Examination created successfully. Now add questions.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | List Examinations
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $exams = $this->examModel
            ->where('examiner_id', session('user_id'))
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('exams/index', [
            'exams' => $exams
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Review Examination
    |--------------------------------------------------------------------------
    */

    public function review($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        $questionModel = new QuestionModel();


        $questions = $questionModel
            ->where('exam_id', $id)
            ->orderBy('id', 'ASC')
            ->findAll();


        return view('exams/review', [

            'exam' => $exam,

            'questions' => $questions
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Examination
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $examModel = new ExamModel();

        $exam = $examModel->find($id);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Security: examiner should only edit their own exam
        if ($exam['examiner_id'] != session('user_id')) {
            return redirect()->to('/dashboard')
                ->with('error', 'You are not authorized to edit this examination.');
        }

        return view('exams/edit', [
            'exam' => $exam
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update Examination
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


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

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }


        $examData = [

            'title' => trim(
                $this->request->getPost('title')
            ),

            'subject' => trim(
                $this->request->getPost('subject')
            ),

            'description' => trim(
                $this->request->getPost('description')
            ),

            'instructions' => trim(
                $this->request->getPost('instructions')
            ),

            'duration' => $this->request
                ->getPost('duration'),

            'total_marks' => $this->request
                ->getPost('total_marks'),

            'passing_marks' => $this->request
                ->getPost('passing_marks'),

            'max_attempts' => $this->request
                ->getPost('max_attempts'),

            'negative_marking' => $this->request
                ->getPost('negative_marking'),

            'exam_date' => $this->request
                ->getPost('exam_date'),

            'start_time' => $this->request
                ->getPost('start_time'),

            'end_time' => $this->request
                ->getPost('end_time')
        ];


        $this->examModel->update($id, $examData);


        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Examination Results
    |--------------------------------------------------------------------------
    */

    public function results($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        return view('exams/results', [

            'exam' => $exam
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Examination
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | Future Flow
        |--------------------------------------------------------------------------
        |
        | 1. Find invited students.
        | 2. Send cancellation email.
        | 3. Delete exam-related records.
        | 4. Delete examination.
        |
        */


        $this->examModel->delete($id);


        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Share Examination Page
    |--------------------------------------------------------------------------
    */

    public function share($id)
    {
        $examModel = new ExamModel();

        $exam = $examModel->find($id);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Security check
        if ($exam['examiner_id'] != session('user_id')) {
            return redirect()->to('/dashboard')
                ->with('error', 'You are not authorized to share this examination.');
        }

        $studentModel = new StudentModel();

        $students = $studentModel
            ->where('examiner_id', session('user_id'))
            ->findAll();

        $examStudentModel = new ExamStudentModel();

        $selectedStudents = $examStudentModel
            ->where('exam_id', $id)
            ->findColumn('student_id');

        if (!$selectedStudents) {
            $selectedStudents = [];
        }

        return view('exams/share', [
            'exam' => $exam,
            'students' => $students,
            'selectedStudents' => $selectedStudents
        ]);
    }

    public function shareStudents($id)
    {
        $examModel = new ExamModel();
        $examStudentModel = new ExamStudentModel();


        /*
        |--------------------------------------------------------------------------
        | Find Exam
        |--------------------------------------------------------------------------
        */

        $exam = $examModel->find($id);


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        }


        /*
        |--------------------------------------------------------------------------
        | Check Exam Ownership
        |--------------------------------------------------------------------------
        */

        if ($exam['examiner_id'] != session('user_id')) {

            return redirect()
                ->to('/dashboard')
                ->with(
                    'error',
                    'You are not authorized to share this examination.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Selected Students
        |--------------------------------------------------------------------------
        */

        $students = $this->request->getPost('students');


        if (empty($students) || !is_array($students)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select at least one student.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Save Selected Students
        |--------------------------------------------------------------------------
        */

        $sharedCount = 0;


        foreach ($students as $studentId) {

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Assignment
            |--------------------------------------------------------------------------
            */

            $alreadyExists = $examStudentModel
                ->where('exam_id', $id)
                ->where('student_id', $studentId)
                ->first();


            if (!$alreadyExists) {

                $examStudentModel->insert([

                    'exam_id' => $id,

                    'student_id' => $studentId,

                    'assigned_at' => date('Y-m-d H:i:s')

                ]);


                $sharedCount++;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Redirect With Result
        |--------------------------------------------------------------------------
        */

        if ($sharedCount === 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'The selected students have already received this examination.'
                );

        }


        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination shared successfully with ' .
                $sharedCount .
                ' student(s).'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | Save Selected Students
    |--------------------------------------------------------------------------
    */

    public function sendInvitations($id)
    {
        $examModel = new ExamModel();

        $exam = $examModel->find($id);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Security check
        if ($exam['examiner_id'] != session('user_id')) {
            return redirect()->to('/dashboard')
                ->with('error', 'You are not authorized to share this examination.');
        }

        $studentIds = $this->request->getPost('students');

        if (empty($studentIds)) {
            return redirect()->back()
                ->with('error', 'Please select at least one student.');
        }

        $examStudentModel = new ExamStudentModel();

        // Remove previous student assignments
        $examStudentModel
            ->where('exam_id', $id)
            ->delete();

        // Add selected students
        foreach ($studentIds as $studentId) {

            $examStudentModel->insert([
                'exam_id' => $id,
                'student_id' => $studentId
            ]);
        }

        return redirect()->to('/dashboard')
            ->with(
                'success',
                count($studentIds) . ' student(s) selected for the examination.'
            );
    }

}