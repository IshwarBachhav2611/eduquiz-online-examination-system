<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StudentController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | SHOW STUDENT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $studentModel = new StudentModel();

        $students = $studentModel
            ->where('examiner_id', session('user_id'))
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('students/index', [
            'students' => $students
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW ADD STUDENT PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('students/create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE STUDENT
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[3]|max_length[100]',
            'email'      => 'required|valid_email|max_length[150]',
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

        $studentModel = new StudentModel();

        /*
        |--------------------------------------------------------------------------
        | CHECK DUPLICATE EMAIL FOR SAME EXAMINER
        |--------------------------------------------------------------------------
        */

        $email = trim(
            $this->request->getPost('email')
        );

        $existingStudent = $studentModel
            ->where('examiner_id', session('user_id'))
            ->where('email', $email)
            ->first();

        if ($existingStudent) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'A student with this email already exists.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE STUDENT
        |--------------------------------------------------------------------------
        */

        $studentModel->insert([

            'examiner_id' => session('user_id'),

            'name' => trim(
                $this->request->getPost('name')
            ),

            'email' => $email,

            'department' => trim(
                $this->request->getPost('department')
            )
        ]);


        return redirect()
            ->to('/students/create')
            ->with(
                'success',
                'Student added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW EDIT STUDENT PAGE
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $studentModel = new StudentModel();

        /*
        |--------------------------------------------------------------------------
        | Only allow the logged-in examiner to access their own student
        |--------------------------------------------------------------------------
        */

        $student = $studentModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$student) {

            return redirect()
                ->to('/students')
                ->with(
                    'error',
                    'Student not found.'
                );
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
        $rules = [
            'name'       => 'required|min_length[3]|max_length[100]',
            'email'      => 'required|valid_email|max_length[150]',
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


        $studentModel = new StudentModel();


        /*
        |--------------------------------------------------------------------------
        | Find student belonging to logged-in examiner
        |--------------------------------------------------------------------------
        */

        $student = $studentModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$student) {

            return redirect()
                ->to('/students')
                ->with(
                    'error',
                    'Student not found.'
                );
        }


        $email = trim(
            $this->request->getPost('email')
        );


        /*
        |--------------------------------------------------------------------------
        | CHECK EMAIL DUPLICATE
        |--------------------------------------------------------------------------
        |
        | Same examiner cannot have two students with the same email.
        | Different examiners can use the same email.
        |
        */

        $existingStudent = $studentModel
            ->where('examiner_id', session('user_id'))
            ->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($existingStudent) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Another student with this email already exists.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $studentModel->update($id, [

            'name' => trim(
                $this->request->getPost('name')
            ),

            'email' => $email,

            'department' => trim(
                $this->request->getPost('department')
            )
        ]);


        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE STUDENT
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $studentModel = new StudentModel();

        /*
        |--------------------------------------------------------------------------
        | Find student belonging to logged-in examiner
        |--------------------------------------------------------------------------
        */

        $student = $studentModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$student) {

            return redirect()
                ->to('/students')
                ->with(
                    'error',
                    'Student not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete student
        |--------------------------------------------------------------------------
        */

        $studentModel->delete($id);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW STUDENT
    |--------------------------------------------------------------------------
    */
    public function view($id)
    {
        $studentModel = new StudentModel();

        // Make sure this student belongs to the logged-in examiner
        $student = $studentModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$student) {
            return redirect()
                ->to('/students')
                ->with('error', 'Student not found.');
        }


        $db = \Config\Database::connect();


        /*
        |--------------------------------------------------------------------------
        | EXAMS GIVEN
        |--------------------------------------------------------------------------
        */

        $totalExams = $db
            ->table('attempts')
            ->where('student_id', $id)
            ->countAllResults();


        /*
        |--------------------------------------------------------------------------
        | RESULTS
        |--------------------------------------------------------------------------
        */

        $results = $db
            ->table('results')
            ->select('
                results.id,
                results.status AS result_status,
                results.rank,
                results.published_at,
                attempts.exam_id,
                attempts.score,
                attempts.percentage,
                attempts.submitted_at,
                exams.title AS exam_title
            ')
            ->join(
                'attempts',
                'attempts.id = results.attempt_id'
            )
            ->join(
                'exams',
                'exams.id = attempts.exam_id'
            )
            ->where('attempts.student_id', $id)
            ->orderBy('results.published_at', 'DESC')
            ->get()
            ->getResultArray();


        /*
        |--------------------------------------------------------------------------
        | PASS / FAIL COUNT
        |--------------------------------------------------------------------------
        */

        $passed = 0;
        $failed = 0;

        foreach ($results as $result) {

            if ($result['result_status'] === 'Pass') {

                $passed++;

            } elseif ($result['result_status'] === 'Fail') {

                $failed++;
            }
        }


        return view('students/view', [

            'student'    => $student,

            'totalExams' => $totalExams,

            'passed'     => $passed,

            'failed'     => $failed,

            'results'    => $results

        ]);
    }
}