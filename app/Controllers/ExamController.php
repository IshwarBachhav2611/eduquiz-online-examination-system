<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\StudentModel;
use App\Models\ExamStudentModel;
use App\Models\ExaminerStudentModel;

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

            return redirect()
                ->back()
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

            return redirect()
                ->to('/dashboard')
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
    | Publish Examination
    |--------------------------------------------------------------------------
    */

    public function finish($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        if ($exam['status'] === 'Published') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This examination is already published.'
                );
        }


        $questionModel = new QuestionModel();


        $questionCount = $questionModel
            ->where('exam_id', $id)
            ->countAllResults();


        if ($questionCount === 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Add at least one question before publishing the examination.'
                );
        }


        $this->examModel->update($id, [

            'status' => 'Published'

        ]);


        return redirect()
            ->to('/exams/review/' . $id)
            ->with(
                'success',
                'Examination published successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Examination
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
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

            'end_time' => 'required',

            'status' => 'required|in_list[Draft,Published]'
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


        $status = $this->request->getPost('status');


        if (
            $status === 'Published' &&
            $exam['status'] !== 'Published'
        ) {

            $questionModel = new QuestionModel();


            $questionCount = $questionModel
                ->where('exam_id', $id)
                ->countAllResults();


            if ($questionCount === 0) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Add at least one question before publishing the examination.'
                    );
            }
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
        /*
        |----------------------------------------------------------------------
        | Find Examination
        |----------------------------------------------------------------------
        */

        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |----------------------------------------------------------------------
        | Get Students Belonging To Current Examiner
        |----------------------------------------------------------------------
        |
        | students table no longer contains examiner_id.
        |
        | Therefore we use examiner_students table:
        |
        | examiner_id -> student_id
        |
        */

        $examinerStudentModel = new ExaminerStudentModel();

        $studentModel = new StudentModel();


        $studentRelations = $examinerStudentModel
            ->where('examiner_id', session('user_id'))
            ->findAll();


        $students = [];


        foreach ($studentRelations as $relation) {

            $student = $studentModel
                ->where('id', $relation['student_id'])
                ->first();


            if ($student) {

                $students[] = $student;
            }
        }


        /*
        |----------------------------------------------------------------------
        | Get Students Already Assigned To This Examination
        |----------------------------------------------------------------------
        */

        $examStudentModel = new ExamStudentModel();


        $selectedStudents = $examStudentModel
            ->where('exam_id', $id)
            ->findColumn('student_id');


        if (!$selectedStudents) {

            $selectedStudents = [];
        }


        /*
        |----------------------------------------------------------------------
        | Load View
        |----------------------------------------------------------------------
        */

        return view('exams/share', [

            'exam' => $exam,

            'students' => $students,

            'selectedStudents' => $selectedStudents

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Share Examination With Students
    |--------------------------------------------------------------------------
    */

    public function shareStudents($id)
    {
        $examModel = new ExamModel();

        $examStudentModel = new ExamStudentModel();

        $examinerStudentModel = new ExaminerStudentModel();


        /*
        |----------------------------------------------------------------------
        | Find Examination
        |----------------------------------------------------------------------
        */

        $exam = $examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |----------------------------------------------------------------------
        | Get Selected Students
        |----------------------------------------------------------------------
        */

        $students = $this->request->getPost('students');


        if (
            empty($students) ||
            !is_array($students)
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select at least one student.'
                );
        }


        /*
        |----------------------------------------------------------------------
        | Verify Students Belong To Examiner
        |----------------------------------------------------------------------
        */

        $validStudents = [];


        foreach ($students as $studentId) {

            $relation = $examinerStudentModel
                ->where('examiner_id', session('user_id'))
                ->where('student_id', $studentId)
                ->first();


            if ($relation) {

                $validStudents[] = $studentId;
            }
        }


        if (empty($validStudents)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'No valid students were selected.'
                );
        }


        /*
        |----------------------------------------------------------------------
        | Save Students For Examination
        |----------------------------------------------------------------------
        */

        $sharedCount = 0;


        foreach ($validStudents as $studentId) {

            $alreadyExists = $examStudentModel
                ->where('exam_id', $id)
                ->where('student_id', $studentId)
                ->first();


            if (!$alreadyExists) {

                $examStudentModel->insert([

                    'exam_id' => $id,

                    'student_id' => $studentId,

                    'created_at' => date('Y-m-d H:i:s')

                ]);


                $sharedCount++;
            }
        }


        /*
        |----------------------------------------------------------------------
        | Result
        |----------------------------------------------------------------------
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
    | Send Invitations
    |--------------------------------------------------------------------------
    */

    public function sendInvitations($id)
    {
        $examModel = new ExamModel();

        $examStudentModel = new ExamStudentModel();

        $examinerStudentModel = new ExaminerStudentModel();


        /*
        |----------------------------------------------------------------------
        | Find Examination
        |----------------------------------------------------------------------
        */

        $exam = $examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();


        if (!$exam) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |----------------------------------------------------------------------
        | Get Selected Students
        |----------------------------------------------------------------------
        */

        $studentIds = $this->request->getPost('students');


        if (
            empty($studentIds) ||
            !is_array($studentIds)
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select at least one student.'
                );
        }


        /*
        |----------------------------------------------------------------------
        | Remove Existing Assignments
        |----------------------------------------------------------------------
        */

        $examStudentModel
            ->where('exam_id', $id)
            ->delete();


        /*
        |----------------------------------------------------------------------
        | Add Valid Students
        |----------------------------------------------------------------------
        */

        $count = 0;


        foreach ($studentIds as $studentId) {

            /*
            |------------------------------------------------------------------
            | Verify Student Belongs To Examiner
            |------------------------------------------------------------------
            */

            $relation = $examinerStudentModel
                ->where('examiner_id', session('user_id'))
                ->where('student_id', $studentId)
                ->first();


            if (!$relation) {

                continue;
            }


            $examStudentModel->insert([

                'exam_id' => $id,

                'student_id' => $studentId,

                'created_at' => date('Y-m-d H:i:s')

            ]);


            $count++;
        }


        /*
        |----------------------------------------------------------------------
        | Result
        |----------------------------------------------------------------------
        */

        if ($count === 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'No valid students were selected.'
                );
        }


        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                $count .
                ' student(s) selected for the examination.'
            );
    }
}