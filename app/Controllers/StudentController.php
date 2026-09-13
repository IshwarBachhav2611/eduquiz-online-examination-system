<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ExaminerStudentModel;

class StudentController extends BaseController
{
    protected $studentModel;
    protected $examinerStudentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->examinerStudentModel = new ExaminerStudentModel();
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $examinerId = session('user_id');

        $students = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'examiner_students.examiner_id',
                $examinerId
            )
            ->orderBy('students.name', 'ASC')
            ->findAll();

        return view('students/index', [
            'students' => $students
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE STUDENT PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('students/create');
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE NEW STUDENT
    |--------------------------------------------------------------------------
    |
    | This creates a completely new global student account.
    |
    */

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]',
            'department' => 'required|max_length[100]'
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

        $examinerId = session('user_id');

        $name = trim(
            $this->request->getPost('name')
        );

        $email = strtolower(
            trim($this->request->getPost('email'))
        );

        $department = trim(
            $this->request->getPost('department')
        );


        /*
        |--------------------------------------------------------------------------
        | CHECK EMAIL
        |--------------------------------------------------------------------------
        */

        $existingStudent = $this->studentModel
            ->where('email', $email)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | EXISTING STUDENT
        |--------------------------------------------------------------------------
        */

        if ($existingStudent) {

            $alreadyLinked = $this->examinerStudentModel
                ->where('examiner_id', $examinerId)
                ->where('student_id', $existingStudent['id'])
                ->first();

            if ($alreadyLinked) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'This student is already in your student list.'
                    );
            }


            $result = $this->examinerStudentModel->insert([
                'examiner_id' => $examinerId,
                'student_id' => $existingStudent['id']
            ]);


            /*
            |--------------------------------------------------------------------------
            | CHECK INSERT ERROR
            |--------------------------------------------------------------------------
            */

            if ($result === false) {

                log_message(
                    'error',
                    'ExaminerStudent INSERT failed: ' .
                    json_encode($this->examinerStudentModel->errors())
                );

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Unable to add existing student. Please check the database.'
                    );
            }


            return redirect()
                ->to('/students')
                ->with(
                    'success',
                    'Existing student added to your student list.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $plainPassword = bin2hex(
            random_bytes(4)
        );


        /*
        |--------------------------------------------------------------------------
        | CREATE STUDENT ACCOUNT
        |--------------------------------------------------------------------------
        */

        $studentId = $this->studentModel->insert([
            'name' => $name,
            'email' => $email,
            'department' => $department,
            'password' => password_hash(
                $plainPassword,
                PASSWORD_DEFAULT
            ),
            'status' => 'Active'
        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK STUDENT INSERT
        |--------------------------------------------------------------------------
        */

        if ($studentId === false) {

            log_message(
                'error',
                'Student INSERT failed: ' .
                json_encode($this->studentModel->errors())
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create student account.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONNECT STUDENT WITH EXAMINER
        |--------------------------------------------------------------------------
        */

        $linkId = $this->examinerStudentModel->insert([
            'examiner_id' => $examinerId,
            'student_id' => $studentId
        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK RELATIONSHIP INSERT
        |--------------------------------------------------------------------------
        */

        if ($linkId === false) {

            log_message(
                'error',
                'ExaminerStudent INSERT failed: ' .
                json_encode($this->examinerStudentModel->errors())
            );

            /*
            |--------------------------------------------------------------
            | Remove student because relationship failed
            |--------------------------------------------------------------
            */

            $this->studentModel->delete($studentId);

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to add student. Please try again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student added successfully.'
            )
            ->with(
                'student_credentials',
                [
                    'email' => $email,
                    'password' => $plainPassword
                ]
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADD EXISTING STUDENT
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ADD EXISTING STUDENT
    |--------------------------------------------------------------------------
    */

    public function addExisting($studentId)
    {
        $examinerId = session('user_id');

        /*
        |--------------------------------------------------------------------------
        | FIND STUDENT
        |--------------------------------------------------------------------------
        */

        $student = $this->studentModel
            ->where('id', $studentId)
            ->first();

        if (!$student) {

            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Student not found.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK WHETHER ALREADY LINKED
        |--------------------------------------------------------------------------
        */

        $alreadyLinked = $this->examinerStudentModel
            ->where('examiner_id', $examinerId)
            ->where('student_id', $studentId)
            ->first();

        if ($alreadyLinked) {

            return $this->response
                ->setJSON([
                    'success' => false,
                    'message' => 'This student is already in your student list.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE EXAMINER-STUDENT RELATIONSHIP
        |--------------------------------------------------------------------------
        */

        $result = $this->examinerStudentModel->insert([
            'examiner_id' => $examinerId,
            'student_id' => $studentId
        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK INSERT
        |--------------------------------------------------------------------------
        */

        if ($result === false) {

            log_message(
                'error',
                'ExaminerStudent INSERT failed: ' .
                json_encode(
                    $this->examinerStudentModel->errors()
                )
            );

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Unable to add student. Please try again.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return $this->response
            ->setJSON([
                'success' => true,
                'message' => 'Student added to your student list successfully.',
                'student' => [
                    'id' => $student['id'],
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'department' => $student['department']
                ]
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT STUDENT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $student = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'students.id',
                $id
            )
            ->where(
                'examiner_students.examiner_id',
                session('user_id')
            )
            ->first();


        if (!$student) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        return view('students/edit', [
            'student' => $student
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STUDENT
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {
        $examinerId = session('user_id');


        /*
        |--------------------------------------------------------------------------
        | VERIFY STUDENT BELONGS TO THIS EXAMINER
        |--------------------------------------------------------------------------
        */

        $student = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'students.id',
                $id
            )
            ->where(
                'examiner_students.examiner_id',
                $examinerId
            )
            ->first();


        if (!$student) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]',
            'department' => 'required|max_length[100]'
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


        $email = strtolower(
            trim($this->request->getPost('email'))
        );


        /*
        |--------------------------------------------------------------------------
        | CHECK GLOBAL EMAIL DUPLICATE
        |--------------------------------------------------------------------------
        */

        $duplicate = $this->studentModel
            ->where(
                'email',
                $email
            )
            ->where(
                'id !=',
                $id
            )
            ->first();


        if ($duplicate) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Another student already exists with this email address.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $this->studentModel->update(
            $id,
            [
                'name' => trim(
                    $this->request->getPost('name')
                ),

                'email' => $email,

                'department' => trim(
                    $this->request->getPost('department')
                )
            ]
        );


        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE STUDENT FROM EXAMINER
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | We do NOT delete the global student account.
    |
    */

    public function delete($id)
    {
        $examinerId = session('user_id');


        $relationship = $this->examinerStudentModel
            ->where(
                'examiner_id',
                $examinerId
            )
            ->where(
                'student_id',
                $id
            )
            ->first();


        if (!$relationship) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        $this->examinerStudentModel
            ->where(
                'examiner_id',
                $examinerId
            )
            ->where(
                'student_id',
                $id
            )
            ->delete();


        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student removed from your student list.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW STUDENT
    |--------------------------------------------------------------------------
    */

    public function view($id)
    {
        $student = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'students.id',
                $id
            )
            ->where(
                'examiner_students.examiner_id',
                session('user_id')
            )
            ->first();


        if (!$student) {

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        return view('students/view', [
            'student' => $student
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DYNAMIC STUDENT SEARCH
    |--------------------------------------------------------------------------
    |
    | Searches globally by:
    | - Name
    | - Email
    |
    | Returns JSON for AJAX.
    |
    */

    public function search()
    {
        $query = trim(
            $this->request->getGet('q') ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | EMPTY SEARCH
        |--------------------------------------------------------------------------
        */

        if ($query === '') {

            return $this->response
                ->setJSON([]);
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH GLOBAL STUDENT ACCOUNTS
        |--------------------------------------------------------------------------
        */

        $students = $this->studentModel
            ->groupStart()
                ->like('name', $query)
                ->orLike('email', $query)
            ->groupEnd()
            ->orderBy('name', 'ASC')
            ->findAll(10);


        /*
        |--------------------------------------------------------------------------
        | GET CURRENT EXAMINER'S STUDENTS
        |--------------------------------------------------------------------------
        */

        $linkedStudentIds = $this->examinerStudentModel
            ->where(
                'examiner_id',
                session('user_id')
            )
            ->findColumn('student_id');


        if (!$linkedStudentIds) {
            $linkedStudentIds = [];
        }


        /*
        |--------------------------------------------------------------------------
        | PREPARE RESPONSE
        |--------------------------------------------------------------------------
        */

        $results = [];


        foreach ($students as $student) {

            $results[] = [
                'id' => $student['id'],

                'name' => $student['name'],

                'email' => $student['email'],

                'department' => $student['department'],

                'already_added' => in_array(
                    $student['id'],
                    $linkedStudentIds
                )
            ];
        }


        return $this->response
            ->setJSON($results);
    }
}