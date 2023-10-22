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

//group offices routes with auth filter 
$routes->group('offices', ['filter' => 'groupfilter:admin'], function ($routes) {
    $routes->get('/', 'OfficeSectionDivisionController::index');
    $routes->get('list', 'OfficeSectionDivisionController::getall');
    $routes->post('/', 'OfficeSectionDivisionController::insert');
    $routes->put('/', 'OfficeSectionDivisionController::update');
    $routes->delete('(:num)', 'OfficeSectionDivisionController::delete/$1');
});

$routes->group('tickets', ['filter' => 'auth'] ,function ($routes) {
    $routes->get('/', 'TicketController::index');
    $routes->get('list', 'TicketController::getall');
    $routes->post('/', 'TicketController::insert');
    $routes->put('/', 'TicketController::update');
    $routes->delete('(:num)', 'TicketController::delete/$1');
});

$routes->group('users', ['filter' => 'groupfilter:admin'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('list', 'UserController::getall');
    $routes->get('allinfo', 'UserController::getallinfolive');
    $routes->post('/', 'UserController::insert');
    $routes->put('/', 'UserController::update');
    $routes->put('changepassword', 'UserController::changePassword');
    $routes->put('(:num)', 'UserController::toggleUserActivityStatus/$1');
    $routes->put('toggleUserStatus', 'UserController::toggleUserStatus');
    $routes->delete('(:num)', 'UserController::delete/$1');
});

$routes->group('roles', ['filter' => 'groupfilter:admin'], function ($routes) {
    $routes->get('/', 'AuthGroupUserController::index');
    $routes->get('list', 'AuthGroupUserController::getall');
    $routes->post('/', 'AuthGroupUserController::insert');
    $routes->put('(:num)', 'AuthGroupUserController::changeRole/$1');
    $routes->delete('(:num)', 'AuthGroupUserController::delete/$1');
});


service('auth')->routes($routes);
