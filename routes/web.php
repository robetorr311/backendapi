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
$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('usuario/all', ['uses' => 'ComunController@indexUsuario']);
  $router->get('usuario/{id}', ['uses' => 'ComunController@showUsuario']);
  $router->post('usuario', ['uses' => 'ComunController@storeUsuario']);
  $router->put('usuario/{id}', ['uses' => 'ComunController@updateUsuario']);
  $router->delete('usuario/{id}', ['uses' => 'ComunController@destroyUsuario']);

  $router->get('estado/all', ['uses' => 'ComunController@indexEstado']);
  $router->get('estado/{id}', ['uses' => 'ComunController@showEstado']);
  $router->post('estado', ['uses' => 'ComunController@storeEstado']);
  $router->put('estado/{id}', ['uses' => 'ComunController@updateEstado']);
  $router->delete('estado/{id}', ['uses' => 'ComunController@destroyEstado']);

  $router->get('municipio/all', ['uses' => 'ComunController@indexMunicipio']);
  $router->get('municipio/{id}', ['uses' => 'ComunController@showMunicipio']);
  $router->post('municipio', ['uses' => 'ComunController@storeMunicipio']);
  $router->put('municipio/{id}', ['uses' => 'ComunController@updateMunicipio']);
  $router->delete('municipio/{id}', ['uses' => 'ComunController@destroyMunicipio']);

  $router->get('parroquia/all', ['uses' => 'ComunController@indexParroquia']);
  $router->get('parroquia/{id}', ['uses' => 'ComunController@showParroquia']);
  $router->post('parroquia', ['uses' => 'ComunController@storeParroquia']);
  $router->put('parroquia/{id}', ['uses' => 'ComunController@updateParroquia']);
  $router->delete('parroquia/{id}', ['uses' => 'ComunController@destroyParroquia']);

  $router->get('localidad/all', ['uses' => 'ComunController@indexLocalidad']);
  $router->get('localidad/{id}', ['uses' => 'ComunController@showLocalidad']);
  $router->post('localidad', ['uses' => 'ComunController@storeLocalidad']);
  $router->put('localidad/{id}', ['uses' => 'ComunController@updateLocalidad']);
  $router->delete('localidad/{id}', ['uses' => 'ComunController@destroyLocalidad']);

  $router->get('sistema/all', ['uses' => 'ComunController@indexSistema']);
  $router->get('sistema/{id}', ['uses' => 'ComunController@showSistema']);
  $router->post('sistema', ['uses' => 'ComunController@storeSistema']);
  $router->put('sistema/{id}', ['uses' => 'ComunController@updateSistema']);
  $router->delete('sistema/{id}', ['uses' => 'ComunController@destroySistema']);

  $router->get('estatus/all', ['uses' => 'ComunController@indexEstatus']);
  $router->get('estatus/{id}', ['uses' => 'ComunController@showEstatus']);
  $router->post('estatus', ['uses' => 'ComunController@storeEstatus']);
  $router->put('estatus/{id}', ['uses' => 'ComunController@updateEstatus']);
  $router->delete('estatus/{id}', ['uses' => 'ComunController@destroyEstatus']);

  $router->get('perfil/all', ['uses' => 'ComunController@indexPerfil']);
  $router->get('perfil/{id}', ['uses' => 'ComunController@showPerfil']);
  $router->post('perfil', ['uses' => 'ComunController@storePerfil']);
  $router->put('perfil/{id}', ['uses' => 'ComunController@updatePerfil']);
  $router->delete('perfil/{id}', ['uses' => 'ComunController@destroyPerfil']);

  $router->get('tipoestatus/all', ['uses' => 'ComunController@indexTipoEstatus']);
  $router->get('tipoestatus/{id}', ['uses' => 'ComunController@showTipoEstatus']);
  $router->post('tipoestatus', ['uses' => 'ComunController@storeTipoEstatus']);
  $router->put('tipoestatus/{id}', ['uses' => 'ComunController@updateTipoEstatus']);
  $router->delete('tipoestatus/{id}', ['uses' => 'ComunController@destroyTipoEstatus']);

  $router->get('menu/all', ['uses' => 'ComunController@indexMenu']);
  $router->get('menu/{id}', ['uses' => 'ComunController@showMenu']);
  $router->post('menu', ['uses' => 'ComunController@storeMenu']);
  $router->put('menu/{id}', ['uses' => 'ComunController@updateMenu']);
  $router->delete('menu/{id}', ['uses' => 'ComunController@destroyMenu']);

  $router->get('permisos/all', ['uses' => 'ComunController@indexPermisos']);
  $router->get('permisos/{id}', ['uses' => 'ComunController@showPermisos']);
  $router->post('permisos', ['uses' => 'ComunController@storePermisos']);
  $router->put('permisos/{id}', ['uses' => 'ComunController@updatePermisos']);
  $router->delete('permisos/{id}', ['uses' => 'ComunController@destroyPermisos']);

  $router->get('permisos/all', ['uses' => 'ComunController@indexPermisos']);
  $router->get('permisos/{id}', ['uses' => 'ComunController@showPermisos']);
  $router->post('permisos', ['uses' => 'ComunController@storePermisos']);
  $router->put('permisos/{id}', ['uses' => 'ComunController@updatePermisos']);
  $router->delete('permisos/{id}', ['uses' => 'ComunController@destroyPermisos']);



});


