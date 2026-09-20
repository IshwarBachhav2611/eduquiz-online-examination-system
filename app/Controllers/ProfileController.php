<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Examiner Login
        |--------------------------------------------------------------------------
        */

        $userId = session('user_id');

        if (!$userId) {

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Please login to access your profile.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Examiner
        |--------------------------------------------------------------------------
        */

        $user = $this->userModel
            ->where('id', $userId)
            ->first();


        if (!$user) {

            return redirect()
                ->to('/dashboard')
                ->with(
                    'error',
                    'Unable to find your account.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Show Profile
        |--------------------------------------------------------------------------
        */

        return view('profile', [
            'user' => $user
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Login
        |--------------------------------------------------------------------------
        */

        $userId = session('user_id');

        if (!$userId) {

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Please login to update your profile.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Current User
        |--------------------------------------------------------------------------
        */

        $user = $this->userModel
            ->where('id', $userId)
            ->first();


        if (!$user) {

            return redirect()
                ->to('/dashboard')
                ->with(
                    'error',
                    'Unable to find your account.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        |
        | Email is intentionally NOT included here because it cannot
        | be changed from the teacher profile.
        |
        */

        $rules = [

            'name' => [
                'label' => 'Full Name',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],

            'organization' => [
                'label' => 'Organization',
                'rules' => 'required|min_length[2]|max_length[150]'
            ],

            'designation' => [
                'label' => 'Designation',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],

            'mobile' => [
                'label' => 'Mobile Number',
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
        | Profile Data
        |--------------------------------------------------------------------------
        |
        | Notice that email is NOT included.
        |
        */

        $updateData = [

            'name' => trim(
                $this->request->getPost('name')
            ),

            'organization' => trim(
                $this->request->getPost('organization')
            ),

            'designation' => trim(
                $this->request->getPost('designation')
            ),

            'mobile' => trim(
                $this->request->getPost('mobile')
            )

        ];


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        $newPassword = $this->request
            ->getPost('new_password');


        if (!empty($newPassword)) {

            $updateData['password'] = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Database
        |--------------------------------------------------------------------------
        */

        $this->userModel->update(
            $userId,
            $updateData
        );


        /*
        |--------------------------------------------------------------------------
        | Update Session
        |--------------------------------------------------------------------------
        |
        | This makes the new name and organization immediately visible
        | in the navbar without requiring logout/login.
        |
        */

        session()->set([

            'name' => $updateData['name'],

            'organization' =>
                $updateData['organization']

        ]);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/profile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}