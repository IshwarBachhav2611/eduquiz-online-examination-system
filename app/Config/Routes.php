<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing Page
$routes->get('/', 'HomeController::index');

// Authentication
$routes->get('/register', 'ExaminerAuthController::register');
$routes->post('/register', 'ExaminerAuthController::registerPost');

$routes->get('/login', 'ExaminerAuthController::login');
$routes->post('/login', 'ExaminerAuthController::loginPost');

$routes->get('/logout', 'ExaminerAuthController::logout');

// Dashboard
$routes->get('/dashboard', 'DashboardController::index');