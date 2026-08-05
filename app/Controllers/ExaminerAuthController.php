<?php

namespace App\Controllers;

use App\Models\UserModel;

class ExaminerAuthController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Registration Page
    |--------------------------------------------------------------------------
    */
    public function register()
    {
        return view('auth/register');
    }

    /*
    |--------------------------------------------------------------------------
    | Register Examiner
    |--------------------------------------------------------------------------
    */
    public function registerPost()
    {
        $rules = [

            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Please enter your full name.'
                ]
            ],

            'organization' => [
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required' => 'Organization / Institute is required.'
                ]
            ],

            'designation' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please select your designation.'
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'is_unique' => 'An account already exists with this email.'
                ]
            ],

            'mobile' => [
                'rules' => 'required|numeric|exact_length[10]',
                'errors' => [
                    'required' => 'Mobile number is required.',
                    'exact_length' => 'Mobile number must contain exactly 10 digits.'
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must contain at least 8 characters.'
                ]
            ],

            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password.',
                    'matches' => 'Passwords do not match.'
                ]
            ]

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());

        }

        $userModel = new UserModel();

        $userModel->save([

            'name' => trim($this->request->getPost('name')),

            'organization' => trim($this->request->getPost('organization')),

            'designation' => $this->request->getPost('designation'),

            'email' => strtolower(trim($this->request->getPost('email'))),

            'mobile' => trim($this->request->getPost('mobile')),

            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            )

        ]);

        return redirect()->to('/login')
            ->with('success', 'Registration successful. Please login.');
    }

    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */
    public function login()
    {
        return view('auth/login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login Authentication
    |--------------------------------------------------------------------------
    */
    public function loginPost()
    {
        $userModel = new UserModel();

        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        $user = $userModel
                    ->where('email', $email)
                    ->first();

        if (!$user) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Email address not found.');

        }

        if (!password_verify($password, $user['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Incorrect password.');

        }

        session()->set([

            'user_id' => $user['id'],

            'name' => $user['name'],

            'email' => $user['email'],

            'organization' => $user['organization'],

            'designation' => $user['designation'],

            'logged_in' => true

        ]);

        return redirect()->to('/dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}