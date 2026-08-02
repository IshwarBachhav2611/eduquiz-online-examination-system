<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'HomeController::index');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::registerSave');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::loginCheck');

$routes->get('/logout', 'AuthController::logout');