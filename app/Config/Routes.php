<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'AuthController::showRegisterPage');
$routes->post('/auth/register', 'AuthController::register');
$routes->get('/login', 'AuthController::showLoginPage');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
