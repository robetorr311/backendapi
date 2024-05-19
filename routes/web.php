<?php
use App\Http\Controllers\LumenAuthController;
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

  $router->post('login', ['uses' => 'LumenAuthController@login']);
  $router->post('logout', ['uses' => 'LumenAuthController@logout']);
  $router->post('refresh', ['uses' => 'LumenAuthController@refresh']);
  $router->post('me', ['uses' => 'LumenAuthController@me']);    
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

  $router->get('profesion/all', ['uses' => 'ComunController@indexProfesion']);
  $router->get('profesion/{id}', ['uses' => 'ComunController@showProfesion']);
  $router->post('profesion', ['uses' => 'ComunController@storeProfesion']);
  $router->put('profesion/{id}', ['uses' => 'ComunController@updateProfesion']);
  $router->delete('profesion/{id}', ['uses' => 'ComunController@destroyProfesion']);

  $router->get('alimento/all', ['uses' => 'ComunController@indexAlimento']);
  $router->get('alimento/{id}', ['uses' => 'ComunController@showAlimento']);
  $router->post('alimento', ['uses' => 'ComunController@storeAlimento']);
  $router->put('alimento/{id}', ['uses' => 'ComunController@updateAlimento']);
  $router->delete('alimento/{id}', ['uses' => 'ComunController@destroyAlimento']);

  $router->get('categoria/all', ['uses' => 'ComunController@indexCategoria']);
  $router->get('categoria/{id}', ['uses' => 'ComunController@showCategoria']);
  $router->post('categoria', ['uses' => 'ComunController@storeCategoria']);
  $router->put('categoria/{id}', ['uses' => 'ComunController@updateCategoria']);
  $router->delete('categoria/{id}', ['uses' => 'ComunController@destroyCategoria']);

  $router->get('estadocivil/all', ['uses' => 'ComunController@indexEstadocivil']);
  $router->get('estadocivil/{id}', ['uses' => 'ComunController@showEstadocivil']);
  $router->post('estadocivil', ['uses' => 'ComunController@storeEstadocivil']);
  $router->put('estadocivil/{id}', ['uses' => 'ComunController@updateEstadocivil']);
  $router->delete('estadocivil/{id}', ['uses' => 'ComunController@destroyEstadocivil']);

  $router->get('contacto/all', ['uses' => 'ComunController@indexContacto']);
  $router->get('contacto/{id}', ['uses' => 'ComunController@showContacto']);
  $router->post('contacto', ['uses' => 'ComunController@storeContacto']);
  $router->put('contacto/{id}', ['uses' => 'ComunController@updateContacto']);
  $router->delete('contacto/{id}', ['uses' => 'ComunController@destroyContacto']);

  $router->get('opinion/all', ['uses' => 'ComunController@indexOpinion']);
  $router->get('opinion/{id}', ['uses' => 'ComunController@showOpinion']);
  $router->post('opinion', ['uses' => 'ComunController@storeOpinion']);
  $router->put('opinion/{id}', ['uses' => 'ComunController@updateOpinion']);
  $router->delete('opinion/{id}', ['uses' => 'ComunController@destroyOpinion']);

  $router->get('configuracion/all', ['uses' => 'ComunController@indexConfiguracion']);
  $router->get('configuracion/{id}', ['uses' => 'ComunController@showConfiguracion']);
  $router->post('configuracion', ['uses' => 'ComunController@storeConfiguracion']);
  $router->put('configuracion/{id}', ['uses' => 'ComunController@updateConfiguracion']);
  $router->delete('configuracion/{id}', ['uses' => 'ComunController@destroyConfiguracion']);
  $router->get('paladar_conf/{id}', ['uses' => 'DulcepaladarController@showConfiguracion']);
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

  $router->get('servicio/all', ['uses' => 'ConsultorioController@indexServicio']);
  $router->get('servicio/{id}', ['uses' => 'ConsultorioController@showServicio']);
  $router->post('servicio', ['uses' => 'ConsultorioController@storeServicio']);
  $router->put('servicio/{id}', ['uses' => 'ConsultorioController@updateServicio']);
  $router->delete('servicio/{id}', ['uses' => 'ConsultorioController@destroyServicio']); 

  $router->get('tipodocumento/all', ['uses' => 'ConsultorioController@indexTipodocumento']);
  $router->get('tipodocumento/{id}', ['uses' => 'ConsultorioController@showTipodocumento']);
  $router->post('tipodocumento', ['uses' => 'ConsultorioController@storeTipodocumento']);
  $router->put('tipodocumento/{id}', ['uses' => 'ConsultorioController@updateTipodocumento']);
  $router->delete('tipodocumento/{id}', ['uses' => 'ConsultorioController@destroyTipodocumento']); 

  $router->get('paciente/all', ['uses' => 'ConsultorioController@indexPaciente']);
  $router->get('paciente/{id}', ['uses' => 'ConsultorioController@showPaciente']);
  $router->post('paciente', ['uses' => 'ConsultorioController@storePaciente']);
  $router->put('paciente/{id}', ['uses' => 'ConsultorioController@updatePaciente']);
  $router->delete('paciente/{id}', ['uses' => 'ConsultorioController@destroyPaciente']);

  $router->get('medico/all', ['uses' => 'ConsultorioController@indexMedico']);
  $router->get('medico/{id}', ['uses' => 'ConsultorioController@showMedico']);
  $router->post('medico', ['uses' => 'ConsultorioController@storeMedico']);
  $router->put('medico/{id}', ['uses' => 'ConsultorioController@updateMedico']);
  $router->delete('medico/{id}', ['uses' => 'ConsultorioController@destroyMedico']);

  $router->get('electrocardiograma/all', ['uses' => 'ConsultorioController@indexElectrocardiograma']);
  $router->get('electrocardiograma/{id}', ['uses' => 'ConsultorioController@showElectrocardiograma']);
  $router->post('electrocardiograma', ['uses' => 'ConsultorioController@storeElectrocardiograma']);
  $router->put('electrocardiograma/{id}', ['uses' => 'ConsultorioController@updateElectrocardiograma']);
  $router->delete('electrocardiograma/{id}', ['uses' => 'ConsultorioController@destroyElectrocardiograma']);

  $router->get('documento/all', ['uses' => 'ConsultorioController@indexDocumento']);
  $router->get('documento/{id}', ['uses' => 'ConsultorioController@showDocumento']);
  $router->post('documento', ['uses' => 'ConsultorioController@storeDocumento']);
  $router->put('documento/{id}', ['uses' => 'ConsultorioController@updateDocumento']);
  $router->delete('documento/{id}', ['uses' => 'ConsultorioController@destroyDocumento']);

  $router->get('examenfisico/all', ['uses' => 'ConsultorioController@indexExamenfisico']);
  $router->get('examenfisico/{id}', ['uses' => 'ConsultorioController@showExamenfisico']);
  $router->post('examenfisico', ['uses' => 'ConsultorioController@storeExamenfisico']);
  $router->put('examenfisico/{id}', ['uses' => 'ConsultorioController@updateExamenfisico']);
  $router->delete('examenfisico/{id}', ['uses' => 'ConsultorioController@destroyExamenfisico']);

  $router->get('serviciosmedico/all', ['uses' => 'ConsultorioController@indexServiciosmedico']);
  $router->get('serviciosmedico/{id}', ['uses' => 'ConsultorioController@showServiciosmedico']);
  $router->post('serviciosmedico', ['uses' => 'ConsultorioController@storeServiciosmedico']);
  $router->put('serviciosmedico/{id}', ['uses' => 'ConsultorioController@updateServiciosmedico']);
  $router->delete('serviciosmedico/{id}', ['uses' => 'ConsultorioController@destroyServiciosmedico']);

  $router->get('horario/all', ['uses' => 'ConsultorioController@indexHorario']);
  $router->get('horario/{id}', ['uses' => 'ConsultorioController@showHorario']);
  $router->post('horario', ['uses' => 'ConsultorioController@storeHorario']);
  $router->put('horario/{id}', ['uses' => 'ConsultorioController@updateHorario']);
  $router->delete('horario/{id}', ['uses' => 'ConsultorioController@destroyHorario']);

  $router->get('turno/all', ['uses' => 'ConsultorioController@indexTurno']);
  $router->get('turno/{id}', ['uses' => 'ConsultorioController@showTurno']);
  $router->post('turno', ['uses' => 'ConsultorioController@storeTurno']);
  $router->put('turno/{id}', ['uses' => 'ConsultorioController@updateTurno']);
  $router->delete('turno/{id}', ['uses' => 'ConsultorioController@destroyTurno']);

  $router->get('cita/all', ['uses' => 'ConsultorioController@indexCita']);
  $router->get('cita/{id}', ['uses' => 'ConsultorioController@showCita']);
  $router->post('cita', ['uses' => 'ConsultorioController@storeCita']);
  $router->put('cita/{id}', ['uses' => 'ConsultorioController@updateCita']);
  $router->delete('cita/{id}', ['uses' => 'ConsultorioController@destroyCita']);

  $router->get('morbilidad/all', ['uses' => 'ConsultorioController@indexMorbilidad']);
  $router->get('morbilidad/{id}', ['uses' => 'ConsultorioController@showMorbilidad']);
  $router->post('morbilidad', ['uses' => 'ConsultorioController@storeMorbilidad']);
  $router->put('morbilidad/{id}', ['uses' => 'ConsultorioController@updateMorbilidad']);
  $router->delete('morbilidad/{id}', ['uses' => 'ConsultorioController@destroyMorbilidad']);

  $router->get('medicinainterna/all', ['uses' => 'ConsultorioController@indexMedicinainterna']);
  $router->get('medicinainterna/{id}', ['uses' => 'ConsultorioController@showMedicinainterna']);
  $router->post('medicinainterna', ['uses' => 'ConsultorioController@storeMedicinainterna']);
  $router->put('medicinainterna/{id}', ['uses' => 'ConsultorioController@updateMedicinainterna']);
  $router->delete('medicinainterna/{id}', ['uses' => 'ConsultorioController@destroyMedicinainterna']);

  $router->get('pacienteinfantil/all', ['uses' => 'ConsultorioController@indexPacienteinfantil']);
  $router->get('pacienteinfantil/{id}', ['uses' => 'ConsultorioController@showPacienteinfantil']);
  $router->post('pacienteinfantil', ['uses' => 'ConsultorioController@storePacienteinfantil']);
  $router->put('pacienteinfantil/{id}', ['uses' => 'ConsultorioController@updatePacienteinfantil']);
  $router->delete('pacienteinfantil/{id}', ['uses' => 'ConsultorioController@destroyPacienteinfantil']);

  $router->get('terapiarespiratoria/all', ['uses' => 'ConsultorioController@indexTerapiarespiratoria']);
  $router->get('terapiarespiratoria/{id}', ['uses' => 'ConsultorioController@showTerapiarespiratoria']);
  $router->post('terapiarespiratoria', ['uses' => 'ConsultorioController@storeTerapiarespiratoria']);
  $router->put('terapiarespiratoria/{id}', ['uses' => 'ConsultorioController@updateTerapiarespiratoria']);
  $router->delete('terapiarespiratoria/{id}', ['uses' => 'ConsultorioController@destroyTerapiarespiratoria']);

  $router->get('herencia/all', ['uses' => 'ConsultorioController@indexHerencia']);
  $router->get('herencia/{id}', ['uses' => 'ConsultorioController@showHerencia']);
  $router->post('herencia', ['uses' => 'ConsultorioController@storeHerencia']);
  $router->put('herencia/{id}', ['uses' => 'ConsultorioController@updateHerencia']);
  $router->delete('herencia/{id}', ['uses' => 'ConsultorioController@destroyHerencia']);

  $router->get('antecedentes/all', ['uses' => 'ConsultorioController@indexAntecedentes']);
  $router->get('antecedentes/{id}', ['uses' => 'ConsultorioController@showAntecedentes']);
  $router->post('antecedentes', ['uses' => 'ConsultorioController@storeAntecedentes']);
  $router->put('antecedentes/{id}', ['uses' => 'ConsultorioController@updateAntecedentes']);
  $router->delete('antecedentes/{id}', ['uses' => 'ConsultorioController@destroyAntecedentes']);

  $router->get('laboratorio/all', ['uses' => 'ConsultorioController@indexLaboratorio']);
  $router->get('laboratorio/{id}', ['uses' => 'ConsultorioController@showLaboratorio']);
  $router->post('laboratorio', ['uses' => 'ConsultorioController@storeLaboratorio']);
  $router->put('laboratorio/{id}', ['uses' => 'ConsultorioController@updateLaboratorio']);
  $router->delete('laboratorio/{id}', ['uses' => 'ConsultorioController@destroyLaboratorio']);


});


