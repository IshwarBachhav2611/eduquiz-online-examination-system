<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing
$routes->get('/', 'HomeController::index');

// Examiner Authentication
$routes->get('/register', 'ExaminerAuthController::register');
$routes->post('/register', 'ExaminerAuthController::registerPost');

$routes->get('/login', 'ExaminerAuthController::login');
$routes->post('/login', 'ExaminerAuthController::loginPost');

$routes->get('/logout', 'ExaminerAuthController::logout');

// Examiner Dashboard
$routes->get('/dashboard', 'DashboardController::index');

// Exams
$routes->get('/exams', 'ExamController::index');
$routes->get('/exams/create', 'ExamController::create');
$routes->post('/exams/store', 'ExamController::store');

$routes->get('/exams/edit/(:num)', 'ExamController::edit/$1');
$routes->post('/exams/update/(:num)', 'ExamController::update/$1');

$routes->get('/exams/delete/(:num)', 'ExamController::delete/$1');

$routes->get('/exams/finish/(:num)', 'ExamController::finish/$1');
$routes->get('/exams/review/(:num)', 'ExamController::review/$1');
$routes->get('/exams/results/(:num)', 'ExamController::results/$1');

// Share Exam
$routes->get('/exams/share/(:num)', 'ExamController::share/$1');
$routes->post('/exams/share/(:num)', 'ExamController::shareStudents/$1');

// Questions
$routes->get('/questions/create/(:num)', 'QuestionController::create/$1');
$routes->post('/questions/store/(:num)', 'QuestionController::store/$1');

$routes->get('/questions/edit/(:num)', 'QuestionController::edit/$1');
$routes->post('/questions/update/(:num)', 'QuestionController::update/$1');

$routes->get('/questions/delete/(:num)', 'QuestionController::delete/$1');

// Student Management
$routes->get('/students', 'StudentController::index');
$routes->get('/students/create', 'StudentController::create');
$routes->post('/students/store', 'StudentController::store');

$routes->get('/students/edit/(:num)', 'StudentController::edit/$1');
$routes->post('/students/update/(:num)', 'StudentController::update/$1');

$routes->post('/students/delete/(:num)', 'StudentController::delete/$1');

$routes->get('/students/view/(:num)', 'StudentController::view/$1');

// Student Authentication
$routes->get('/student/login', 'StudentAuthController::login');
$routes->post('/student/login', 'StudentAuthController::loginPost');
$routes->get('/student/logout', 'StudentAuthController::logout');

// Student Assigned Exams
$routes->get('/student/exams', 'StudentExamListController::index');

// Student Examination
$routes->get('/student/exam/start/(:num)', 'StudentExamController::start/$1');
$routes->post('/student/exam/submit/(:num)', 'StudentExamController::submit/$1');
$routes->get('/student/exam/result/(:num)', 'StudentExamController::result/$1');
$routes->get('/student/exams', 'StudentExamListController::index');
$routes->get('/students/search', 'StudentController::search');
$routes->post('/students/add-existing/(:num)','StudentController::addExisting/$1');