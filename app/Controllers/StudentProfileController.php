<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StudentProfileController extends BaseController
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId || !session('student_logged_in')) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login to continue.');
        }

        $student = $this->studentModel
            ->where('id', $studentId)
            ->first();

        if (!$student) {
            session()->remove([
                'student_id',
                'student_name',
                'student_email',
                'student_logged_in'
            ]);

            return redirect()
                ->to('/student/login')
                ->with('error', 'Student account not found.');
        }

        return view('student/profile', [
            'student' => $student
        ]);
    }

    public function update()
    {
        $studentId = session('student_id');

        if (!$studentId || !session('student_logged_in')) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login to continue.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]',
            'department' => 'required|max_length[100]',
            'phone' => 'permit_empty|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(
            trim($this->request->getPost('email'))
        );

        $existingStudent = $this->studentModel
            ->where('email', $email)
            ->where('id !=', $studentId)
            ->first();

        if ($existingStudent) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Another student already exists with this email address.'
                );
        }

        $data = [
            'name' => trim($this->request->getPost('name')),
            'email' => $email,
            'department' => trim($this->request->getPost('department')),
            'phone' => trim($this->request->getPost('phone'))
        ];

        $this->studentModel->update($studentId, $data);

        session()->set([
            'student_name' => $data['name'],
            'student_email' => $data['email']
        ]);

        return redirect()
            ->to('/student/profile')
            ->with('success', 'Profile updated successfully.');
    }
}