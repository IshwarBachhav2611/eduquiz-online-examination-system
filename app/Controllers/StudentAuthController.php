<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StudentAuthController extends BaseController
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    public function login()
    {
        return view('student_auth/login');
    }

    public function loginPost()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $student = $this->studentModel
            ->where('email', $email)
            ->where('status', 'Active')
            ->first();

        if (!$student || !password_verify($password, $student['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        session()->set([
            'student_id' => $student['id'],
            'student_name' => $student['name'],
            'student_email' => $student['email'],
            'student_logged_in' => true
        ]);

        return redirect()
            ->to('/student/exams')
            ->with('success', 'Welcome, ' . $student['name'] . '!');
    }

    public function logout()
    {
        session()->remove([
            'student_id',
            'student_name',
            'student_email',
            'student_logged_in'
        ]);

        return redirect()
            ->to('/student/login')
            ->with('success', 'You have been logged out successfully.');
    }
}