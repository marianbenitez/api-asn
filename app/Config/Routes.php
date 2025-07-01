<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('api', static function ($routes) {
    $routes->get('test', 'Api\\TestController::index');
    $routes->get('test/protected', 'Api\\TestController::protected', ['filter' => 'auth-token']);
    $routes->get('test/admin', 'Api\\TestController::adminOnly', ['filter' => 'auth-token']);
});

