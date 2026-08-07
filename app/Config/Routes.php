<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//-----------------------------------------------------
// Landing Page
//-----------------------------------------------------

$routes->get('/', 'HomeController::index');

//-----------------------------------------------------
// Authentication
//-----------------------------------------------------

$routes->get('/register', 'ExaminerAuthController::register');
$routes->post('/register', 'ExaminerAuthController::registerPost');

$routes->get('/login', 'ExaminerAuthController::login');
$routes->post('/login', 'ExaminerAuthController::loginPost');

$routes->get('/logout', 'ExaminerAuthController::logout');

//-----------------------------------------------------
// Dashboard
//-----------------------------------------------------

$routes->get('/dashboard', 'DashboardController::index');

//-----------------------------------------------------
// Examination Module
//-----------------------------------------------------

$routes->get('/exams', 'ExamController::index');

$routes->get('/exams/create', 'ExamController::create');
$routes->post('/exams/store', 'ExamController::store');

$routes->get('/exams/edit/(:num)', 'ExamController::edit/$1');
$routes->post('/exams/update/(:num)', 'ExamController::update/$1');

$routes->get('/exams/delete/(:num)', 'ExamController::delete/$1');

//-----------------------------------------------------
// Question Module
//-----------------------------------------------------

$routes->get('/questions/create/(:num)', 'QuestionController::create/$1');

$routes->post('/questions/store/(:num)', 'QuestionController::store/$1');

$routes->get('/questions/edit/(:num)', 'QuestionController::edit/$1');

$routes->post('/questions/update/(:num)', 'QuestionController::update/$1');

$routes->get('/questions/delete/(:num)', 'QuestionController::delete/$1');