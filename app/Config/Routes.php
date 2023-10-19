<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);
// $routes->get('/', 'DashboardController::index');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();


$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('users', 'UserController::index');
$routes->get('users/list', 'UserController::getall');
$routes->get('offices', 'OfficeSectionDivisionController::index');
$routes->get('offices/list', 'OfficeSectionDivisionController::getall');
$routes->resource('offices', ['controller' => 'OfficeSectionDivisionController', 'filter' => 'auth'], ['except' => 'insert']);

$routes->get('authors/list', 'AuthorController::getall');

// $routers->resource('users', ['controller' => 'UserController']);
$routes->resource('authors', ['controller' => 'AuthorController']);
//add put route for authors controller to update author data by id 
$routes->put('authors/(:num)', 'AuthorController::update/$1');

$routes->resource('posts', ['controller' => 'PostController']);


service('auth')->routes($routes);
