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

    /**
     * Display student profile
     */
    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login to access your profile.');
        }

        $student = $this->studentModel
            ->where('id', $studentId)
            ->first();

        if (!$student) {
            return redirect()
                ->to('/student/exams')
                ->with('error', 'Unable to find your account.');
        }

        return view('student/profile', [
            'student' => $student
        ]);
    }


    /**
     * Update student profile
     */
    public function update()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login to update your profile.');
        }

        $student = $this->studentModel
            ->where('id', $studentId)
            ->first();

        if (!$student) {
            return redirect()
                ->to('/student/exams')
                ->with('error', 'Unable to find your account.');
        }


        /*
        |--------------------------------------------------------------------------
        | Validation Rules
        |--------------------------------------------------------------------------
        */

        $rules = [
            'name' => [
                'label' => 'Full Name',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],

            'department' => [
                'label' => 'Department',
                'rules' => 'required|min_length[2]|max_length[150]'
            ],

            'phone' => [
                'label' => 'Phone Number',
                'rules' => 'required|numeric|min_length[10]|max_length[15]'
            ],

            'new_password' => [
                'label' => 'New Password',
                'rules' => 'permit_empty|min_length[6]|max_length[255]'
            ],

            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'permit_empty|matches[new_password]'
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


        /*
        |--------------------------------------------------------------------------
        | Basic Profile Information
        |--------------------------------------------------------------------------
        */

        $updateData = [
            'name' => trim(
                $this->request->getPost('name')
            ),

            'department' => trim(
                $this->request->getPost('department')
            ),

            'phone' => trim(
                $this->request->getPost('phone')
            )
        ];


        /*
        |--------------------------------------------------------------------------
        | Password Update
        |--------------------------------------------------------------------------
        */

        $newPassword = $this->request->getPost('new_password');

        if (!empty($newPassword)) {

            $updateData['password'] = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );


            /*
            |--------------------------------------------------------------------------
            | Demo / Academic Project Password Storage
            |--------------------------------------------------------------------------
            |
            | Your current project also contains plain_password because
            | you previously requested the actual password to be visible
            | in the student profile.
            |
            | This is NOT recommended for a real production system.
            |
            */

            $updateData['plain_password'] = $newPassword;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Database
        |--------------------------------------------------------------------------
        */

        $this->studentModel->update(
            $studentId,
            $updateData
        );


        /*
        |--------------------------------------------------------------------------
        | Update Session Information
        |--------------------------------------------------------------------------
        */

        session()->set([
            'student_name' => $updateData['name']
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/student/profile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}