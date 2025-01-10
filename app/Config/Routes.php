<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('category/(:num)', 'HomeController::index/$1');

// Ürün detay
$routes->get('product/(:num)', 'HomeController::detail/$1');

// Auth işlemleri
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginPost');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerPost');
$routes->get('logout', 'AuthController::logout');

$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->get('cart/remove/(:num)', 'CartController::remove/$1');
$routes->get('checkout', 'CartController::checkout');

$routes->post('orders/complete', 'OrderController::complete');
$routes->get('orders', 'OrderController::index');
$routes->get('orders/detail/(:num)', 'OrderController::details/$1');


// Profil
$routes->get('profile', 'ProfileController::index');

$routes->get('favorites/', 'FavoritesController::index');
$routes->get('favorites/add/(:num)', 'FavoritesController::add/$1');
$routes->get('favorites/remove/(:num)', 'FavoritesController::remove/$1');
