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

  $router->get('orden/all', ['uses' => 'VentasController@indexOrden']);
  $router->get('orden/{id}', ['uses' => 'VentasController@showOrden']);
  $router->post('orden', ['uses' => 'VentasController@storeOrden']);
  $router->put('orden/{id}', ['uses' => 'VentasController@updateOrden']);
  $router->delete('orden/{id}', ['uses' => 'VentasController@destroyOrden']);

  $router->get('pago/all', ['uses' => 'VentasController@indexPago']);
  $router->get('pago/{id}', ['uses' => 'VentasController@showPago']);
  $router->post('pago', ['uses' => 'VentasController@storePago']);
  $router->put('pago/{id}', ['uses' => 'VentasController@updatePago']);
  $router->delete('pago/{id}', ['uses' => 'VentasController@destroyPago']);

  $router->get('metodospago/all', ['uses' => 'VentasController@indexMetodospago']);
  $router->get('metodospago/{id}', ['uses' => 'VentasController@showMetodospago']);
  $router->post('metodospago', ['uses' => 'VentasController@storeMetodospago']);
  $router->put('metodospago/{id}', ['uses' => 'VentasController@updateMetodospago']);
  $router->delete('metodospago/{id}', ['uses' => 'VentasController@destroyMetodospago']);

  $router->get('tiposmetodo/all', ['uses' => 'VentasController@indexTiposmetodo']);
  $router->get('tiposmetodo/{id}', ['uses' => 'VentasController@showTiposmetodo']);
  $router->post('tiposmetodo', ['uses' => 'VentasController@storeTiposmetodo']);
  $router->put('tiposmetodo/{id}', ['uses' => 'VentasController@updateTiposmetodo']);
  $router->delete('tiposmetodo/{id}', ['uses' => 'VentasController@destroyTiposmetodo']);

  $router->get('entrega/all', ['uses' => 'VentasController@indexEntrega']);
  $router->get('entrega/{id}', ['uses' => 'VentasController@showEntrega']);
  $router->post('entrega', ['uses' => 'VentasController@storeEntrega']);
  $router->put('entrega/{id}', ['uses' => 'VentasController@updateEntrega']);
  $router->delete('entrega/{id}', ['uses' => 'VentasController@destroyEntrega']); 

  $router->get('tipoentrega/all', ['uses' => 'VentasController@indexTipoentrega']);
  $router->get('tipoentrega/{id}', ['uses' => 'VentasController@showTipoentrega']);
  $router->post('tipoentrega', ['uses' => 'VentasController@storeTipoentrega']);
  $router->put('tipoentrega/{id}', ['uses' => 'VentasController@updateTipoentrega']);
  $router->delete('tipoentrega/{id}', ['uses' => 'VentasController@destroyTipoentrega']);   

  $router->get('courier/all', ['uses' => 'VentasController@indexCourier']);
  $router->get('courier/{id}', ['uses' => 'VentasController@showCourier']);
  $router->post('courier', ['uses' => 'VentasController@storeCourier']);
  $router->put('courier/{id}', ['uses' => 'VentasController@updateCourier']);
  $router->delete('courier/{id}', ['uses' => 'VentasController@destroyCourier']);  

  $router->get('articulo/all', ['uses' => 'InventarioController@indexArticulo']);
  $router->get('articulo/{id}', ['uses' => 'InventarioController@showArticulo']);
  $router->post('articulo', ['uses' => 'InventarioController@storeArticulo']);
  $router->put('articulo/{id}', ['uses' => 'InventarioController@updateArticulo']);
  $router->delete('articulo/{id}', ['uses' => 'InventarioController@destroyArticulo']);  

  $router->get('imagenarticulo/all', ['uses' => 'InventarioController@indexImagenarticulo']);
  $router->get('imagenarticulo/{id}', ['uses' => 'InventarioController@showImagenarticulo']);
  $router->post('imagenarticulo', ['uses' => 'InventarioController@storeImagenarticulo']);
  $router->put('imagenarticulo/{id}', ['uses' => 'InventarioController@updateImagenarticulo']);
  $router->delete('imagenarticulo/{id}', ['uses' => 'InventarioController@destroyImagenarticulo']);  

  $router->get('entrada/all', ['uses' => 'InventarioController@indexEntrada']);
  $router->get('entrada/{id}', ['uses' => 'InventarioController@showEntrada']);
  $router->post('entrada', ['uses' => 'InventarioController@storeEntrada']);
  $router->put('entrada/{id}', ['uses' => 'InventarioController@updateEntrada']);
  $router->delete('entrada/{id}', ['uses' => 'InventarioController@destroyEntrada']); 

  $router->get('movimiento/all', ['uses' => 'InventarioController@indexMovimiento']);
  $router->get('movimiento/{id}', ['uses' => 'InventarioController@showMovimiento']);
  $router->post('movimiento', ['uses' => 'InventarioController@storeMovimiento']);
  $router->put('movimiento/{id}', ['uses' => 'InventarioController@updateMovimiento']);
  $router->delete('movimiento/{id}', ['uses' => 'InventarioController@destroyMovimiento']); 

  $router->get('salida/all', ['uses' => 'InventarioController@indexSalida']);
  $router->get('salida/{id}', ['uses' => 'InventarioController@showSalida']);
  $router->post('salida', ['uses' => 'InventarioController@storeSalida']);
  $router->put('salida/{id}', ['uses' => 'InventarioController@updateSalida']);
  $router->delete('salida/{id}', ['uses' => 'InventarioController@destroySalida']); 

  $router->get('tipomovimiento/all', ['uses' => 'InventarioController@indexTipomovimiento']);
  $router->get('tipomovimiento/{id}', ['uses' => 'InventarioController@showTipomovimiento']);
  $router->post('tipomovimiento', ['uses' => 'InventarioController@storeTipomovimiento']);
  $router->put('tipomovimiento/{id}', ['uses' => 'InventarioController@updateTipomovimiento']);
  $router->delete('tipomovimiento/{id}', ['uses' => 'InventarioController@destroyTipomovimiento']);   

  $router->get('presentacion/all', ['uses' => 'InventarioController@indexPresentacion']);
  $router->get('presentacion/{id}', ['uses' => 'InventarioController@showPresentacion']);
  $router->post('presentacion', ['uses' => 'InventarioController@storePresentacion']);
  $router->put('presentacion/{id}', ['uses' => 'InventarioController@updatePresentacion']);
  $router->delete('presentacion/{id}', ['uses' => 'InventarioController@destroyPresentacion']); 

  $router->get('existencia/all', ['uses' => 'InventarioController@indexExistencia']);
  $router->get('existencia/{id}', ['uses' => 'InventarioController@showExistencia']);
});


