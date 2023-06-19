<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/estado/all', 'ComunController@indexEstado');
$router->get('/api/estado/{id}', 'ComunController@showEstado');
$router->post('/api/estado', 'ComunController@storeEstado');
$router->put('/api/estado/{id}', 'ComunController@updateEstado');
$router->delete('/api/estado/{id}', 'ComunController@destroyEstado');