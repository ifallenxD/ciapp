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
//group offices routes with auth filter 
$routes->group('offices', function ($routes) {
    $routes->get('/', 'OfficeSectionDivisionController::index');
    $routes->get('list', 'OfficeSectionDivisionController::getall');
    $routes->post('/', 'OfficeSectionDivisionController::insert');
    $routes->put('/', 'OfficeSectionDivisionController::update');
    $routes->delete('(:num)', 'OfficeSectionDivisionController::delete/$1');
});

$routes->group('tickets', function ($routes) {
    $routes->get('/', 'TicketController::index');
    $routes->get('list', 'TicketController::getall');
    $routes->post('/', 'TicketController::insert');
    $routes->put('/', 'TicketController::update');
    $routes->delete('(:num)', 'TicketController::delete/$1');
});


$routes->get('authors/list', 'AuthorController::getall');

// $routers->resource('users', ['controller' => 'UserController']);
$routes->resource('authors', ['controller' => 'AuthorController']);
//add put route for authors controller to update author data by id 
$routes->put('authors/(:num)', 'AuthorController::update/$1');

$routes->resource('posts', ['controller' => 'PostController']);


service('auth')->routes($routes);
