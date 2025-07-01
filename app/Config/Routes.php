<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('api', static function ($routes) {
    $routes->post('login', 'Api\\UserController::login'); // Login route to get token

    $routes->get('test', 'Api\\TestController::index');
    $routes->get('test/protected', 'Api\\TestController::protected', ['filter' => 'auth-token']);
    $routes->get('test/admin', 'Api\\TestController::adminOnly', ['filter' => 'auth-token']);

    // User management routes
    $routes->get('users', 'Api\\UserController::index', ['filter' => 'auth-token']);
    $routes->post('users', 'Api\\UserController::create', ['filter' => 'auth-token']);
});

