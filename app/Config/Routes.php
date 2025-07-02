<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// Aplicar filtro CORS a todas las rutas API
$routes->group('api', ['filter' => 'cors'], static function ($routes) {
    // Ruta de login (sin autenticación)
    $routes->post('login', 'Api\\UserController::login');

    // Rutas de testing
    $routes->get('test', 'Api\\TestController::index');
    $routes->get('test/protected', 'Api\\TestController::protected', ['filter' => 'auth-token']);
    $routes->get('test/admin', 'Api\\TestController::adminOnly', ['filter' => 'auth-token']);

    // Rutas de gestión de usuarios (requieren autenticación)
    $routes->get('users', 'Api\\UserController::index', ['filter' => 'auth-token']);
    $routes->post('users', 'Api\\UserController::create', ['filter' => 'auth-token']);
    
    // Manejar preflight OPTIONS requests
    $routes->options('(:any)', static function () {
        return response()->setStatusCode(200);
    });
});