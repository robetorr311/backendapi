<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Antecedente;
use App\Models\Documento;
use App\Models\Electrocardiograma;
use App\Models\Examenfisico;
use App\Models\Herencia;
use App\Models\Horario;
use App\Models\Medicinainterna;
use App\Models\Medico;
use App\Models\Morbilidad;
use App\Models\Paciente;
use App\Models\Pacienteinfantil;
use App\Models\Servicio;
use App\Models\Serviciosmedico;
use App\Models\Terapiarespiratoria;
use App\Models\Tipodocumento;
use App\Models\Turno;
use App\Models\Alimento;
use App\Models\Pais;
use App\Models\Laboratorio;
use App\Models\Configuracion;
use App\Models\Profesion;
use App\Models\Estadocivil;
use App\Models\User;
class ConsultorioController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function indexServicio(){
        try
        {
            $Servicios = Servicio::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Servicios'
                ]
            ], 500);
        }
        if($Servicios)
        {
            $data = [];
            foreach($Servicios as $Servicio)
            {
                $types = [];
                $types = [
                    'id' => $Servicio->id,
                    'nombre' => $Servicio->nombre
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Servicios was not found'
                ]
            ], 404);
        }
    }
    public function showServicio($id){
        try
        {
            $Servicio = Servicio::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Servicios'
                ]
            ], 500);
        }
        if($Servicio)
        {
            $data = [];
            $data = [
                'id' => $Servicio->id,
                'nombre' => $Servicio->nombre
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Servicio was not found'
                ]
            ], 404);
        }
    }
    public function storeServicio(Request $request){
        
        $data = new Servicio();
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error storing Servicios'
                ]
            ], 500);
        }
    }
    public function updateServicio($id, Request $request){
        
        try
        {
            $data = Servicio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Servicios'
                ]
            ], 500);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error updating Servicios'
                ]
            ], 500);
        }
    }
    public function destroyServicio($id){
        try
        {
            $data = Servicio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Servicio'
                ]
            ], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error deleting Servicio'
                ]
            ], 500);
        }
    }
    public function indexTipodocumento(){
        try
        {
            $Tipodocumentos = Tipodocumento::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipodocumentos'
                ]
            ], 500);
        }
        if($Tipodocumentos)
        {
            $data = [];
            foreach($Tipodocumentos as $Tipodocumento)
            {
                $types = [];
                $types = [
                    'id' => $Tipodocumento->id,
                    'nombre' => $Tipodocumento->nombre
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Tipodocumentos was not found'
                ]
            ], 404);
        }
    }
    public function showTipodocumento($id){
        try
        {
            $Tipodocumento = Tipodocumento::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipodocumentos'
                ]
            ], 500);
        }
        if($Tipodocumento)
        {
            $data = [];
            $data = [
                'id' => $Tipodocumento->id,
                'nombre' => $Tipodocumento->nombre
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Tipodocumento was not found'
                ]
            ], 404);
        }
    }
    public function storeTipodocumento(Request $request){
        
        $data = new Tipodocumento();

        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error storing Tipodocumentos'
                ]
            ], 500);
        }
    }
    public function updateTipodocumento($id, Request $request){
        
        try
        {
            $data = Tipodocumento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipodocumentos'
                ]
            ], 500);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error updating Tipodocumentos'
                ]
            ], 500);
        }
    }
    public function destroyTipodocumento($id){
        try
        {
            $data = Tipodocumento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipodocumento'
                ]
            ], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error deleting Tipodocumento'
                ]
            ], 500);
        }
    }
    public function indexPaciente(){
        try
        {
            $Pacientes = Paciente::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacientes'
                ]
            ], 500);
        }
        if($Pacientes)
        {
            $data = [];
            foreach($Pacientes as $Paciente)
            {
                $types = [];
                $types = [
                    'id' => $Paciente->id,
                    'cedula' => $Paciente->cedula,
                    'nombre' => $Paciente->nombre,
                    'fechadenacimiento' => $Paciente->fechadenacimiento,
                    'sexo' => $Paciente->sexo,
                    'email' => $Paciente->email,
                    'telefono_domicilio' => $Paciente->telefono_domicilio,
                    'telefono_movil' => $Paciente->telefono_movil,
                    'direccion' => $Paciente->direccion,
                    'id_estado' => $Paciente->id_estado,
                    'id_municipio' => $Paciente->id_municipio,
                    'id_parroquia' => $Paciente->id_parroquia,
                    'id_localidad' => $Paciente->id_localidad,
                    'id_herencia' => $Paciente->id_herencia,
                    'id_profesion' => $Paciente->id_profesion,
                    'id_estadocivil' => $Paciente->id_estadocivil,
                    'id_estatus' => $Paciente->id_estatus,
                    'id_antecedentes' => $Paciente->id_antecedentes,
                    'id_usuario' => $Paciente->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Pacientes was not found'
                ]
            ], 404);
        }
    }
    public function showPaciente($id){
        try
        {
            $Paciente = Paciente::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacientes'
                ]
            ], 500);
        }
        if($Paciente)
        {
            $data = [];
            $data = [
                'id' => $Paciente->id,
                'cedula' => $Paciente->cedula,
                'nombre' => $Paciente->nombre,
                'fechadenacimiento' => $Paciente->fechadenacimiento,
                'sexo' => $Paciente->sexo,
                'email' => $Paciente->email,
                'telefono_domicilio' => $Paciente->telefono_domicilio,
                'telefono_movil' => $Paciente->telefono_movil,
                'direccion' => $Paciente->direccion,
                'id_estado' => $Paciente->id_estado,
                'id_municipio' => $Paciente->id_municipio,
                'id_parroquia' => $Paciente->id_parroquia,
                'id_localidad' => $Paciente->id_localidad,
                'id_herencia' => $Paciente->id_herencia,
                'id_profesion' => $Paciente->id_profesion,
                'id_estadocivil' => $Paciente->id_estadocivil,
                'id_estatus' => $Paciente->id_estatus,
                'id_antecedentes' => $Paciente->id_antecedentes,
                'id_usuario' => $Paciente->id_usuario
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Paciente was not found'
                ]
            ], 404);
        }
    }
    public function storePaciente(Request $request){
        
        $data = new Paciente();
        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }            
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_herencia')){
            if(is_int($request->input('id_herencia'))){
                $data->id_herencia=$request->input('id_herencia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_herencia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_profesion')){
            if(is_int($request->input('id_profesion'))){
                $data->id_profesion=$request->input('id_profesion');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_profesion debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_profesion no puede estar vacio']], 422);
        }
        if($request->input('id_estadocivil')){
            if(is_int($request->input('id_estadocivil'))){
                $data->id_estadocivil=$request->input('id_estadocivil');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estadocivil debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estadocivil no puede estar vacio']], 422);
        }
        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }            
        if($request->input('id_antecedentes')){
            if(is_int($request->input('id_antecedentes'))){
                $data->id_antecedentes=$request->input('id_antecedentes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_antecedentes debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_antecedentes no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error storing Pacientes'
                ]
            ], 500);
        }
    }
    public function updatePaciente($id, Request $request){
        
        try
        {
            $data = Paciente::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacientes'
                ]
            ], 500);
        }
        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }            
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_herencia')){
            if(is_int($request->input('id_herencia'))){
                $data->id_herencia=$request->input('id_herencia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_herencia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_profesion')){
            if(is_int($request->input('id_profesion'))){
                $data->id_profesion=$request->input('id_profesion');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_profesion debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_profesion no puede estar vacio']], 422);
        }
        if($request->input('id_estadocivil')){
            if(is_int($request->input('id_estadocivil'))){
                $data->id_estadocivil=$request->input('id_estadocivil');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estadocivil debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estadocivil no puede estar vacio']], 422);
        }
        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }            
        if($request->input('id_antecedentes')){
            if(is_int($request->input('id_antecedentes'))){
                $data->id_antecedentes=$request->input('id_antecedentes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_antecedentes debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_antecedentes no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error updating Pacientes'
                ]
            ], 500);
        }
    }
    public function destroyPaciente($id){
        try
        {
            $data = Paciente::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Paciente'
                ]
            ], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error deleting Paciente'
                ]
            ], 500);
        }
    }
    public function indexMedico(){
        try
        {
            $Medicos = Medico::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medicos']], 500);
        }
        if($Medicos)
        {
            $data = [];
            foreach($Medicos as $Medico)
            {
                $types = [];
                $types = [
                    'id' => $Medico->id,
                    'cedula' => $Medico->cedula,
                    'nombre' => $Medico->nombre,
                    'mpps' => $Medico->mpps,
                    'colegio' => $Medico->colegio,
                    'fechadenacimiento' => $Medico->fechadenacimiento,
                    'sexo' => $Medico->sexo,
                    'email' => $Medico->email,
                    'telefono_domicilio' => $Medico->telefono_domicilio,
                    'telefono_movil' => $Medico->telefono_movil,
                    'direccion' => $Medico->direccion,
                    'id_estado' => $Medico->id_estado,
                    'id_municipio' => $Medico->id_municipio,
                    'id_parroquia' => $Medico->id_parroquia,
                    'id_localidad' => $Medico->id_localidad,
                    'id_usuario' => $Medico->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Medicos was not found']], 404);
        }
    }
    public function showMedico($id){
        try
        {
            $Medico = Medico::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medicos']], 500);
        }
        if($Medico)
        {
            $data = [];
            $data = [
                'id' => $Medico->id,
                'cedula' => $Medico->cedula,
                'nombre' => $Medico->nombre,
                'mpps' => $Medico->mpps,
                'colegio' => $Medico->colegio,
                'fechadenacimiento' => $Medico->fechadenacimiento,
                'sexo' => $Medico->sexo,
                'email' => $Medico->email,
                'telefono_domicilio' => $Medico->telefono_domicilio,
                'telefono_movil' => $Medico->telefono_movil,
                'direccion' => $Medico->direccion,
                'id_estado' => $Medico->id_estado,
                'id_municipio' => $Medico->id_municipio,
                'id_parroquia' => $Medico->id_parroquia,
                'id_localidad' => $Medico->id_localidad,
                'id_usuario' => $Medico->id_usuario
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Medico was not found']], 404);
        }
    }
    public function storeMedico(Request $request){
        
        $data = new Medico();

        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('mpps')){
            $data->mpps = $request->input('mpps');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'mpps no puede estar vacio']], 422);
        }
        if($request->input('colegio')){
            $data->colegio = $request->input('colegio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'colegio no puede estar vacio']], 422);
        }
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fechadenacimiento no puede estar vacio']], 422);
        }
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'sexo no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'email no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'telefono_domicilio no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'telefono_movil no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'direccion no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estado no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_usuario'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_municipio no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_parroquia'))){
                $data->id_parroquia=$request->input('id_parroquia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_parroquia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_parroquia no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_localidad no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Medicos']], 500);
        }
    }
    public function updateMedico($id, Request $request){
        
        try
        {
            $data = Medico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Medicos'
                ]
            ], 500);
        }
        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('mpps')){
            $data->mpps = $request->input('mpps');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'mpps no puede estar vacio']], 422);
        }
        if($request->input('colegio')){
            $data->colegio = $request->input('colegio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'colegio no puede estar vacio']], 422);
        }
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fechadenacimiento no puede estar vacio']], 422);
        }
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'sexo no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'email no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'telefono_domicilio no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'telefono_movil no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'direccion no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estado no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_usuario'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_municipio no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_parroquia'))){
                $data->id_parroquia=$request->input('id_parroquia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_parroquia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_parroquia no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_localidad no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Medicos']], 500);
        }
    }
    public function destroyMedico($id){
        try
        {
            $data = Medico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medico']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Medico']], 500);
        }
    }
    public function indexElectrocardiograma(){
        try
        {
            $Electrocardiogramas = Electrocardiograma::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Electrocardiogramas']], 500);
        }
        if($Electrocardiogramas)
        {
            $data = [];
            foreach($Electrocardiogramas as $Electrocardiograma)
            {
                $types = [];
                $types = [
                    'id' => $Electrocardiograma->id,
                    'nombrearchivo' => $Electrocardiograma->nombrearchivo,
                    'url' => $Electrocardiograma->url,
                    'id_paciente' => $Electrocardiograma->id_paciente,
                    'id_usuario' => $Electrocardiograma->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Electrocardiogramas was not found']], 404);
        }
    }
    public function showElectrocardiograma($id){
        try
        {
            $Electrocardiograma = Electrocardiograma::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Electrocardiogramas']], 500);
        }
        if($Electrocardiograma)
        {
            $data = [];
            $data = [
                'id' => $Electrocardiograma->id,
                'nombrearchivo' => $Electrocardiograma->nombrearchivo,
                'url' => $Electrocardiograma->url,
                'id_paciente' => $Electrocardiograma->id_paciente,
                'id_usuario' => $Electrocardiograma->id_usuario
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Electrocardiograma was not found']], 404);
        }
    }
    public function storeElectrocardiograma(Request $request){
        
        $data = new Electrocardiograma();
        if($request->input('nombrearchivo')){
            $data->nombrearchivo = $request->input('nombrearchivo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('url')){
            $data->url = $request->input('url');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Electrocardiogramas']], 500);
        }
    }
    public function updateElectrocardiograma($id, Request $request){
        
        try
        {
            $data = Electrocardiograma::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Electrocardiogramas'
                ]
            ], 500);
        }
        if($request->input('nombrearchivo')){
            $data->nombrearchivo = $request->input('nombrearchivo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('url')){
            $data->url = $request->input('url');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Electrocardiogramas']], 500);
        }
    }
    public function destroyElectrocardiograma($id){
        try
        {
            $data = Electrocardiograma::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Electrocardiograma']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Electrocardiograma']], 500);
        }
    } 
    public function indexDocumento(){
        try
        {
            $Documentos = Documento::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Documentos']], 500);
        }
        if($Documentos)
        {
            $data = [];
            foreach($Documentos as $Documento)
            {
                $types = [];
                $types = [
                    'id' => $Documento->id,
                    'numero' => $Documento->numero,
                    'id_origen' => $Documento->id_origen,
                    'id_destino' => $Documento->id_destino,
                    'id_tipodocumento' => $Documento->id_tipodocumento,
                    'id_estatus' => $Documento->id_estatus,
                    'fecha' => $Documento->fecha,
                    'id_serviciosmedico' => $Documento->id_serviciosmedico,
                    'id_usuario' => $Documento->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Documentos was not found']], 404);
        }
    }
    public function showDocumento($id){
        try
        {
            $Documento = Documento::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Documentos']], 500);
        }
        if($Documento)
        {
            $data = [];
            $data = [
                'id' => $Documento->id,
                'numero' => $Documento->numero,
                'id_origen' => $Documento->id_origen,
                'id_destino' => $Documento->id_destino,
                'id_tipodocumento' => $Documento->id_tipodocumento,
                'id_estatus' => $Documento->id_estatus,
                'fecha' => $Documento->fecha,
                'id_serviciosmedico' => $Documento->id_serviciosmedico,
                'id_usuario' => $Documento->id_usuario
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Documento was not found']], 404);
        }
    }
    public function storeDocumento(Request $request){
        
        $data = new Documento();
        if($request->input('numero')){
            $data->numero = $request->input('numero');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'numero no puede estar vacio']], 422);
        }
        if($request->input('id_origen')){
            if(is_int($request->input('id_origen'))){
                $data->id_origen=$request->input('id_origen');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_origen debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_origen no puede estar vacio']], 422);
        }
        if($request->input('id_destino')){
            if(is_int($request->input('id_destino'))){
                $data->id_destino=$request->input('id_destino');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_destino debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_destino no puede estar vacio']], 422);
        }
        if($request->input('id_tipodocumento')){
            if(is_int($request->input('id_tipodocumento'))){
                $data->id_tipodocumento=$request->input('id_tipodocumento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_tipodocumento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_tipodocumento no puede estar vacio']], 422);
        }
        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_serviciosmedico')){
            if(is_int($request->input('id_serviciosmedico'))){
                $data->id_serviciosmedico=$request->input('id_serviciosmedico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_serviciosmedico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_serviciosmedico no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Documentos']], 500);
        }
    }
    public function updateDocumento($id, Request $request){
        
        try
        {
            $data = Documento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Documentos'
                ]
            ], 500);
        }
        if($request->input('numero')){
            $data->numero = $request->input('numero');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'numero no puede estar vacio']], 422);
        }
        if($request->input('id_origen')){
            if(is_int($request->input('id_origen'))){
                $data->id_origen=$request->input('id_origen');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_origen debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_origen no puede estar vacio']], 422);
        }
        if($request->input('id_destino')){
            if(is_int($request->input('id_destino'))){
                $data->id_destino=$request->input('id_destino');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_destino debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_destino no puede estar vacio']], 422);
        }
        if($request->input('id_tipodocumento')){
            if(is_int($request->input('id_tipodocumento'))){
                $data->id_tipodocumento=$request->input('id_tipodocumento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_tipodocumento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_tipodocumento no puede estar vacio']], 422);
        }
        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_serviciosmedico')){
            if(is_int($request->input('id_serviciosmedico'))){
                $data->id_serviciosmedico=$request->input('id_serviciosmedico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_serviciosmedico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_serviciosmedico no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Documentos']], 500);
        }
    }
    public function destroyDocumento($id){
        try
        {
            $data = Documento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Documento']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Documento']], 500);
        }
    }
    public function indexExamenfisico(){
        try
        {
            $Examenfisicos = Examenfisico::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Examenfisicos']], 500);
        }
        if($Examenfisicos)
        {
            $data = [];
            foreach($Examenfisicos as $Examenfisico)
            {
                $types = [];
                $types = [
                    'id' => $Examenfisico->id,
                    'id_paciente' => $Examenfisico->id_paciente,
                    'fecha' => $Examenfisico->fecha,
                    'sistolica' => $Examenfisico->sistolica,
                    'diastolica' => $Examenfisico->diastolica,
                    'pulso' => $Examenfisico->pulso,
                    'frecuencia_cardiaca' => $Examenfisico->frecuencia_cardiaca,
                    'frecuencia_respiratoria' => $Examenfisico->frecuencia_respiratoria,
                    'peso' => $Examenfisico->peso,
                    'talla' => $Examenfisico->talla,
                    'temperatura' => $Examenfisico->temperatura,
                    'id_electrocardiograma' => $Examenfisico->id_electrocardiograma,
                    'id_hematologia' => $Examenfisico->id_hematologia,
                    'aspecto' => $Examenfisico->aspecto,
                    'id_documento' => $Examenfisico->id_documento,
                    'id_servicio' => $Examenfisico->id_servicio,
                    'id_cita' => $Examenfisico->id_cita
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Examenfisicos was not found']], 404);
        }
    }
    public function showExamenfisico($id){
        try
        {
            $Examenfisico = Examenfisico::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Examenfisicos']], 500);
        }
        if($Examenfisico)
        {
            $data = [];
            $data = [
                'id' => $Examenfisico->id,
                'id_paciente' => $Examenfisico->id_paciente,
                'fecha' => $Examenfisico->fecha,
                'sistolica' => $Examenfisico->sistolica,
                'diastolica' => $Examenfisico->diastolica,
                'pulso' => $Examenfisico->pulso,
                'frecuencia_cardiaca' => $Examenfisico->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $Examenfisico->frecuencia_respiratoria,
                'peso' => $Examenfisico->peso,
                'talla' => $Examenfisico->talla,
                'temperatura' => $Examenfisico->temperatura,
                'id_electrocardiograma' => $Examenfisico->id_electrocardiograma,
                'id_hematologia' => $Examenfisico->id_hematologia,
                'aspecto' => $Examenfisico->aspecto,
                'id_documento' => $Examenfisico->id_documento,
                'id_servicio' => $Examenfisico->id_servicio,
                'id_cita' => $Examenfisico->id_cita
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Examenfisico was not found']], 404);
        }
    }
    public function storeExamenfisico(Request $request){
        
        $data = new Examenfisico();
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '001','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '002','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('sistolica')){
            $data->sistolica = $request->input('sistolica');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '004','error' => 'sistolica no puede estar vacio']], 422);
        }
        if($request->input('diastolica')){
            $data->diastolica = $request->input('diastolica');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'diastolica no puede estar vacio']], 422);
        }
        if($request->input('pulso')){
            $data->pulso = $request->input('pulso');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '006','error' => 'pulso no puede estar vacio']], 422);
        }
        if($request->input('frecuencia_cardiaca')){
            $data->frecuencia_cardiaca = $request->input('frecuencia_cardiaca');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'frecuencia_cardiaca no puede estar vacio']], 422);
        }
        if($request->input('frecuencia_respiratoria')){
            $data->frecuencia_respiratoria = $request->input('frecuencia_respiratoria');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '008','error' => 'frecuencia_respiratoria no puede estar vacio']], 422);
        }
        if($request->input('peso')){
            $data->peso = $request->input('peso');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'peso no puede estar vacio']], 422);
        }
        if($request->input('talla')){
            $data->talla = $request->input('talla');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '010','error' => 'talla no puede estar vacio']], 422);
        }
        if($request->input('temperatura')){
            $data->temperatura = $request->input('temperatura');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'temperatura no puede estar vacio']], 422);
        }
        if($request->input('id_electrocardiograma')){
            if(is_int($request->input('id_electrocardiograma'))){
                $data->id_electrocardiograma=$request->input('id_electrocardiograma');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '012','error' => 'id_electrocardiograma debe ser numero entero']],422);
            }
        }
        if($request->input('id_hematologia')){
            if(is_int($request->input('id_hematologia'))){
                $data->id_hematologia=$request->input('id_hematologia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '013','error' => 'id_hematologia debe ser numero entero']],422);
            }
        }
        if($request->input('aspecto')){
            $data->aspecto = $request->input('aspecto');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'aspecto no puede estar vacio']], 422);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '015','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '016','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '017','error' => 'id_servicio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '018','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_cita')){
            if(is_int($request->input('id_cita'))){
                $data->id_cita=$request->input('id_cita');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '019','error' => 'id_cita debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '020','error' => 'id_cita no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Examenfisicos']], 500);
        }
    }
    public function updateExamenfisico($id, Request $request){
        
        try
        {
            $data = Examenfisico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Examenfisicos'
                ]
            ], 500);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '001','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '002','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('sistolica')){
            $data->sistolica = $request->input('sistolica');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '004','error' => 'sistolica no puede estar vacio']], 422);
        }
        if($request->input('diastolica')){
            $data->diastolica = $request->input('diastolica');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'diastolica no puede estar vacio']], 422);
        }
        if($request->input('pulso')){
            $data->pulso = $request->input('pulso');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '006','error' => 'pulso no puede estar vacio']], 422);
        }
        if($request->input('frecuencia_cardiaca')){
            $data->frecuencia_cardiaca = $request->input('frecuencia_cardiaca');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'frecuencia_cardiaca no puede estar vacio']], 422);
        }
        if($request->input('frecuencia_respiratoria')){
            $data->frecuencia_respiratoria = $request->input('frecuencia_respiratoria');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '008','error' => 'frecuencia_respiratoria no puede estar vacio']], 422);
        }
        if($request->input('peso')){
            $data->peso = $request->input('peso');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'peso no puede estar vacio']], 422);
        }
        if($request->input('talla')){
            $data->talla = $request->input('talla');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '010','error' => 'talla no puede estar vacio']], 422);
        }
        if($request->input('temperatura')){
            $data->temperatura = $request->input('temperatura');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'temperatura no puede estar vacio']], 422);
        }
        if($request->input('id_electrocardiograma')){
            if(is_int($request->input('id_electrocardiograma'))){
                $data->id_electrocardiograma=$request->input('id_electrocardiograma');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '012','error' => 'id_electrocardiograma debe ser numero entero']],422);
            }
        }
        if($request->input('id_hematologia')){
            if(is_int($request->input('id_hematologia'))){
                $data->id_hematologia=$request->input('id_hematologia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '013','error' => 'id_hematologia debe ser numero entero']],422);
            }
        }
        if($request->input('aspecto')){
            $data->aspecto = $request->input('aspecto');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'aspecto no puede estar vacio']], 422);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '015','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '016','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '017','error' => 'id_servicio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '018','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_cita')){
            if(is_int($request->input('id_cita'))){
                $data->id_cita=$request->input('id_cita');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '019','error' => 'id_cita debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '020','error' => 'id_cita no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Examenfisicos']], 500);
        }
    }
    public function destroyExamenfisico($id){
        try
        {
            $data = Examenfisico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Examenfisico']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Examenfisico']], 500);
        }
    }
    public function indexServiciosmedico(){
        try
        {
            $Serviciosmedicos = Serviciosmedico::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Serviciosmedicos']], 500);
        }
        if($Serviciosmedicos)
        {
            $data = [];
            foreach($Serviciosmedicos as $Serviciosmedico)
            {
                $types = [];
                $types = [
                    'id' => $Serviciosmedico->id,
                    'id_medico' => $Serviciosmedico->id_medico,
                    'id_servicio' => $Serviciosmedico->id_servicio,
                    'id_horario' => $Serviciosmedico->id_horario,
                    'id_turno' => $Serviciosmedico->id_turno
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Serviciosmedicos was not found']], 404);
        }
    }
    public function showServiciosmedico($id){
        try
        {
            $Serviciosmedico = Serviciosmedico::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Serviciosmedicos']], 500);
        }
        if($Serviciosmedico)
        {
            $data = [];
            $data = [
                'id' => $Serviciosmedico->id,
                'id_medico' => $Serviciosmedico->id_medico,
                'id_servicio' => $Serviciosmedico->id_servicio,
                'id_horario' => $Serviciosmedico->id_horario,
                'id_turno' => $Serviciosmedico->id_turno
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Serviciosmedico was not found']], 404);
        }
    }
    public function storeServiciosmedico(Request $request){
        
        $data = new Serviciosmedico();
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_servicio debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_horario')){
            if(is_int($request->input('id_horario'))){
                $data->id_horario=$request->input('id_horario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_horario debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_horario no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Serviciosmedicos']], 500);
        }
    }
    public function updateServiciosmedico($id, Request $request){
        
        try
        {
            $data = Serviciosmedico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Serviciosmedicos'
                ]
            ], 500);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_servicio debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_horario')){
            if(is_int($request->input('id_horario'))){
                $data->id_horario=$request->input('id_horario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_horario debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_horario no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        }else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Serviciosmedicos']], 500);
        }
    }
    public function destroyServiciosmedico($id){
        try
        {
            $data = Serviciosmedico::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Serviciosmedico']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Serviciosmedico']], 500);
        }
    }
    public function indexHorario(){
        try
        {
            $Horarios = Horario::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Horarios']], 500);
        }
        if($Horarios)
        {
            $data = [];
            foreach($Horarios as $Horario)
            {
                $types = [];
                $types = [
                    'id' => $Horario->id,
                    'descripcion' => $Horario->descripcion,
                    'id_turno' => $Horario->id_turno,
                    'inicio' => $Horario->inicio,
                    'fin' => $Horario->fin,
                    'cupos' => $Horario->cupos
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Horarios was not found']], 404);
        }
    }
    public function showHorario($id){
        try
        {
            $Horario = Horario::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Horarios']], 500);
        }
        if($Horario)
        {
            $data = [];
            $data = [
                'id' => $Horario->id,
                'descripcion' => $Horario->descripcion,
                'id_turno' => $Horario->id_turno,
                'inicio' => $Horario->inicio,
                'fin' => $Horario->fin,
                'cupos' => $Horario->cupos
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Horario was not found']], 404);
        }
    }
    public function storeHorario(Request $request){
        
        $data = new Horario();
        if($request->input('descripcion')){
            $data->descripcion = $request->input('descripcion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'descripcion no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        if($request->input('inicio')){
            $data->inicio = $request->input('inicio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'inicio no puede estar vacio']], 422);
        }
        if($request->input('fin')){
            $data->fin = $request->input('fin');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fin no puede estar vacio']], 422);
        }
        if($request->input('cupos')){
            if(is_int($request->input('cupos'))){
                $data->cupos=$request->input('cupos');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cupos debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cupos no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Horarios']], 500);
        }
    }
    public function updateHorario($id, Request $request){
        
        try
        {
            $data = Horario::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Horarios'
                ]
            ], 500);
        }
        if($request->input('descripcion')){
            $data->descripcion = $request->input('descripcion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'descripcion no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        if($request->input('inicio')){
            $data->inicio = $request->input('inicio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'inicio no puede estar vacio']], 422);
        }
        if($request->input('fin')){
            $data->fin = $request->input('fin');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fin no puede estar vacio']], 422);
        }
        if($request->input('cupos')){
            if(is_int($request->input('cupos'))){
                $data->cupos=$request->input('cupos');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cupos debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cupos no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Horarios']], 500);
        }
    }
    public function destroyHorario($id){
        try
        {
            $data = Horario::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Horario']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Horario']], 500);
        }
    }
    public function indexTurno(){
        try
        {
            $Turnos = Turno::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Turnos']], 500);
        }
        if($Turnos)
        {
            $data = [];
            foreach($Turnos as $Turno)
            {
                $types = [];
                $types = [
                    'id' => $Turno->id,
                    'nombre' => $Turno->nombre
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Turnos was not found']], 404);
        }
    }
    public function showTurno($id){
        try
        {
            $Turno = Turno::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Turnos']], 500);
        }
        if($Turno)
        {
            $data = [];
            $data = [
                'id' => $Turno->id,
                'nombre' => $Turno->nombre
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Turno was not found']], 404);
        }
    }
    public function storeTurno(Request $request){
        
        $data = new Turno();
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Turnos']], 500);
        }
    }
    public function updateTurno($id, Request $request){
        
        try
        {
            $data = Turno::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Turnos'
                ]
            ], 500);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }else{
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Turnos']], 500);
        }
    }
    public function destroyTurno($id){
        try
        {
            $data = Turno::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Turno']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Turno']], 500);
        }
    }
    public function indexCita(){
        try
        {
            $Citas = Cita::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Citas']], 500);
        }
        if($Citas)
        {
            $data = [];
            foreach($Citas as $Cita)
            {
                $types = [];
                $types = [
                    'id' => $Cita->id,
                    'id_documento' => $Cita->id_documento,
                    'id_paciente' => $Cita->id_paciente,
                    'id_medico' => $Cita->id_medico,
                    'id_servicio' => $Cita->id_servicio,
                    'id_horario' => $Cita->id_horario,
                    'id_turno' => $Cita->id_turno
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Citas was not found']], 404);
        }
    }
    public function showCita($id){
        try
        {
            $Cita = Cita::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Citas']], 500);
        }
        if($Cita)
        {
            $data = [];
            $data = [
                'id' => $Cita->id,
                'id_documento' => $Cita->id_documento,
                'id_paciente' => $Cita->id_paciente,
                'id_medico' => $Cita->id_medico,
                'id_servicio' => $Cita->id_servicio,
                'id_horario' => $Cita->id_horario,
                'id_turno' => $Cita->id_turno
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Cita was not found']], 404);
        }
    }
    public function storeCita(Request $request){
        
        $data = new Cita();
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_horario')){
            if(is_int($request->input('id_horario'))){
                $data->id_horario=$request->input('id_horario');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_horario debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_horario no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Citas']], 500);
        }
    }
    public function updateCita($id, Request $request){
        
        try
        {
            $data = Cita::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Citas'
                ]
            ], 500);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_servicio')){
            if(is_int($request->input('id_servicio'))){
                $data->id_servicio=$request->input('id_servicio');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_servicio no puede estar vacio']], 422);
        }
        if($request->input('id_horario')){
            if(is_int($request->input('id_horario'))){
                $data->id_horario=$request->input('id_horario');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_horario debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_horario no puede estar vacio']], 422);
        }
        if($request->input('id_turno')){
            if(is_int($request->input('id_turno'))){
                $data->id_turno=$request->input('id_turno');
            }
            else {
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_turno debe ser numero entero']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_turno no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Citas']], 500);
        }
    }
    public function destroyCita($id){
        try
        {
            $data = Cita::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Cita']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Cita']], 500);
        }
    } 
    public function indexMorbilidad(){
        try
        {
            $Morbilidads = Morbilidad::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Morbilidads']], 500);
        }
        if($Morbilidads)
        {
            $data = [];
            foreach($Morbilidads as $Morbilidad)
            {
                $types = [];
                $types = [
                    'id' => $Morbilidad->id,
                    'id_documento' => $Morbilidad->id_documento,
                    'fecha' => $Morbilidad->fecha,
                    'id_paciente' => $Morbilidad->id_paciente,
                    'id_medico' => $Morbilidad->id_medico,
                    'id_examenfisico' => $Morbilidad->id_examenfisico,
                    'motivo' => $Morbilidad->motivo,
                    'diagnostico' => $Morbilidad->diagnostico,
                    'enfermedad' => $Morbilidad->enfermedad,
                    'tratamiento' => $Morbilidad->tratamiento
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Morbilidads was not found']], 404);
        }
    }
    public function showMorbilidad($id){
        try
        {
            $Morbilidad = Morbilidad::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Morbilidads']], 500);
        }
        if($Morbilidad)
        {
            $data = [];
            $data = [
                'id' => $Morbilidad->id,
                'id_documento' => $Morbilidad->id_documento,
                'fecha' => $Morbilidad->fecha,
                'id_paciente' => $Morbilidad->id_paciente,
                'id_medico' => $Morbilidad->id_medico,
                'id_examenfisico' => $Morbilidad->id_examenfisico,
                'motivo' => $Morbilidad->motivo,
                'diagnostico' => $Morbilidad->diagnostico,
                'enfermedad' => $Morbilidad->enfermedad,
                'tratamiento' => $Morbilidad->tratamiento
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Morbilidad was not found']], 404);
        }
    }
    public function storeMorbilidad(Request $request){
        
        $data = new Morbilidad();
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('motivo')){
            motivo = $request->input('motivo');
        } 
        if($request->input('diagnostico')){
            diagnostico = $request->input('diagnostico');
        } 
        if($request->input('enfermedad')){
            enfermedad = $request->input('enfermedad');
        }
        if($request->input('tratamiento')){
            tratamiento = $request->input('tratamiento');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Morbilidads']], 500);
        }
    }
    public function updateMorbilidad($id, Request $request){
        
        try
        {
            $data = Morbilidad::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Morbilidads'
                ]
            ], 500);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('motivo')){
            motivo = $request->input('motivo');
        } 
        if($request->input('diagnostico')){
            diagnostico = $request->input('diagnostico');
        } 
        if($request->input('enfermedad')){
            enfermedad = $request->input('enfermedad');
        }
        if($request->input('tratamiento')){
            tratamiento = $request->input('tratamiento');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Morbilidads']], 500);
        }
    }
    public function destroyMorbilidad($id){
        try
        {
            $data = Morbilidad::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Morbilidad']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Morbilidad']], 500);
        }
    }
    public function indexMedicinainterna(){
        try
        {
            $Medicinainternas = Medicinainterna::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medicinainternas']], 500);
        }
        if($Medicinainternas)
        {
            $data = [];
            foreach($Medicinainternas as $Medicinainterna)
            {
                $types = [];
                $types = [
                    'id' => $Medicinainterna->id,
                    'id_documento' => $Medicinainterna->id_documento,
                    'fecha' => $Medicinainterna->fecha,
                    'id_paciente' => $Medicinainterna->id_paciente,
                    'id_medico' => $Medicinainterna->id_medico,
                    'id_examenfisico' => $Medicinainterna->id_examenfisico,
                    'motivo' => $Medicinainterna->motivo,
                    'diagnostico' => $Medicinainterna->diagnostico,
                    'enfermedad' => $Medicinainterna->enfermedad,
                    'tratamiento' => $Medicinainterna->tratamiento
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Medicinainternas was not found']], 404);
        }
    }
    public function showMedicinainterna($id){
        try
        {
            $Medicinainterna = Medicinainterna::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medicinainternas']], 500);
        }
        if($Medicinainterna)
        {
            $data = [];
            $data = [
                'id' => $Medicinainterna->id,
                'id_documento' => $Medicinainterna->id_documento,
                'fecha' => $Medicinainterna->fecha,
                'id_paciente' => $Medicinainterna->id_paciente,
                'id_medico' => $Medicinainterna->id_medico,
                'id_examenfisico' => $Medicinainterna->id_examenfisico,
                'motivo' => $Medicinainterna->motivo,
                'diagnostico' => $Medicinainterna->diagnostico,
                'enfermedad' => $Medicinainterna->enfermedad,
                'tratamiento' => $Medicinainterna->tratamiento
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Medicinainterna was not found']], 404);
        }
    }
    public function storeMedicinainterna(Request $request){
        
        $data = new Medicinainterna();
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('motivo')){
            motivo = $request->input('motivo');
        } 
        if($request->input('diagnostico')){
            diagnostico = $request->input('diagnostico');
        } 
        if($request->input('enfermedad')){
            enfermedad = $request->input('enfermedad');
        }
        if($request->input('tratamiento')){
            tratamiento = $request->input('tratamiento');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Medicinainternas']], 500);
        }
    }
    public function updateMedicinainterna($id, Request $request){
        
        try
        {
            $data = Medicinainterna::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Medicinainternas'
                ]
            ], 500);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('motivo')){
            motivo = $request->input('motivo');
        } 
        if($request->input('diagnostico')){
            diagnostico = $request->input('diagnostico');
        } 
        if($request->input('enfermedad')){
            enfermedad = $request->input('enfermedad');
        }
        if($request->input('tratamiento')){
            tratamiento = $request->input('tratamiento');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Medicinainternas']], 500);
        }
    }
    public function destroyMedicinainterna($id){
        try
        {
            $data = Medicinainterna::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Medicinainterna']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Medicinainterna']], 500);
        }
    }
    public function indexPacienteinfantil(){
        try
        {
            $Pacienteinfantils = Pacienteinfantil::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacienteinfantils'
                ]
            ], 500);
        }
        if($Pacienteinfantils)
        {
            $data = [];
            foreach($Pacienteinfantils as $Pacienteinfantil)
            {
                $types = [];
                $types = [
                    'id' => $Pacienteinfantil->id,
                    'cedula' => $Pacienteinfantil->cedula,
                    'nombre' => $Pacienteinfantil->nombre,
                    'padre' => $Pacienteinfantil->padre,
                    'madre' => $Pacienteinfantil->madre,
                    'fechadenacimiento' => $Pacienteinfantil->fechadenacimiento,
                    'sexo' => $Pacienteinfantil->sexo,
                    'email' => $Pacienteinfantil->email,
                    'telefono_domicilio' => $Pacienteinfantil->telefono_domicilio,
                    'telefono_movil' => $Pacienteinfantil->telefono_movil,
                    'direccion' => $Pacienteinfantil->direccion,
                    'id_estado' => $Pacienteinfantil->id_estado,
                    'id_municipio' => $Pacienteinfantil->id_municipio,
                    'id_parroquia' => $Pacienteinfantil->id_parroquia,
                    'id_localidad' => $Pacienteinfantil->id_localidad,
                    'id_herencia' => $Pacienteinfantil->id_herencia,
                    'id_profesion' => $Pacienteinfantil->id_profesion,
                    'id_estadocivil' => $Pacienteinfantil->id_estadocivil,
                    'id_estatus' => $Pacienteinfantil->id_estatus,
                    'id_antecedentes' => $Pacienteinfantil->id_antecedentes,
                    'id_usuario' => $Pacienteinfantil->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Pacienteinfantils was not found'
                ]
            ], 404);
        }
    }
    public function showPacienteinfantil($id){
        try
        {
            $Pacienteinfantil = Pacienteinfantil::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacienteinfantils'
                ]
            ], 500);
        }
        if($Pacienteinfantil)
        {
            $data = [];
            $data = [
                'id' => $Pacienteinfantil->id,
                'cedula' => $Pacienteinfantil->cedula,
                'nombre' => $Pacienteinfantil->nombre,
                'padre' => $Pacienteinfantil->padre,
                'madre' => $Pacienteinfantil->madre,
                'fechadenacimiento' => $Pacienteinfantil->fechadenacimiento,
                'sexo' => $Pacienteinfantil->sexo,
                'email' => $Pacienteinfantil->email,
                'telefono_domicilio' => $Pacienteinfantil->telefono_domicilio,
                'telefono_movil' => $Pacienteinfantil->telefono_movil,
                'direccion' => $Pacienteinfantil->direccion,
                'id_estado' => $Pacienteinfantil->id_estado,
                'id_municipio' => $Pacienteinfantil->id_municipio,
                'id_parroquia' => $Pacienteinfantil->id_parroquia,
                'id_localidad' => $Pacienteinfantil->id_localidad,
                'id_herencia' => $Pacienteinfantil->id_herencia,
                'id_estatus' => $Pacienteinfantil->id_estatus,
                'id_antecedentes' => $Pacienteinfantil->id_antecedentes,
                'id_usuario' => $Pacienteinfantil->id_usuario
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Pacienteinfantil was not found'
                ]
            ], 404);
        }
    }
    public function storePacienteinfantil(Request $request){
        
        $data = new Pacienteinfantil();
        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('padre')){
            $data->padre = $request->input('padre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'padre no puede estar vacio']], 422);
        }
        if($request->input('madre')){
            $data->madre = $request->input('madre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'madre no puede estar vacio']], 422);
        }                
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }            
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_herencia')){
            if(is_int($request->input('id_herencia'))){
                $data->id_herencia=$request->input('id_herencia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_herencia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }

        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }            
        if($request->input('id_antecedentes')){
            if(is_int($request->input('id_antecedentes'))){
                $data->id_antecedentes=$request->input('id_antecedentes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_antecedentes debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_antecedentes no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error storing Pacienteinfantils'
                ]
            ], 500);
        }
    }
    public function updatePacienteinfantil($id, Request $request){
        
        try
        {
            $data = Pacienteinfantil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacienteinfantils'
                ]
            ], 500);
        }
        if($request->input('cedula')){
            $data->cedula = $request->input('cedula');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'cedula no puede estar vacio']], 422);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('padre')){
            $data->padre = $request->input('padre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'padre no puede estar vacio']], 422);
        }
        if($request->input('madre')){
            $data->madre = $request->input('madre');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'madre no puede estar vacio']], 422);
        }  
        if($request->input('fechadenacimiento')){
            $data->fechadenacimiento = $request->input('fechadenacimiento');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }            
        if($request->input('sexo')){
            $data->sexo = $request->input('sexo');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('email')){
            $data->email = $request->input('email');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_domicilio')){
            $data->telefono_domicilio = $request->input('telefono_domicilio');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('telefono_movil')){
            $data->telefono_movil = $request->input('telefono_movil');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('direccion')){
            $data->direccion = $request->input('direccion');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_estado')){
            if(is_int($request->input('id_estado'))){
                $data->id_estado=$request->input('id_estado');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estado debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_municipio')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_parroquia')){
            if(is_int($request->input('id_municipio'))){
                $data->id_municipio=$request->input('id_municipio');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_municipio debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_localidad')){
            if(is_int($request->input('id_localidad'))){
                $data->id_localidad=$request->input('id_localidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_localidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_herencia')){
            if(is_int($request->input('id_herencia'))){
                $data->id_herencia=$request->input('id_herencia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_herencia debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'Nombre no puede estar vacio']], 422);
        }
        if($request->input('id_profesion')){
            if(is_int($request->input('id_profesion'))){
                $data->id_profesion=$request->input('id_profesion');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_profesion debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_profesion no puede estar vacio']], 422);
        }
        if($request->input('id_estadocivil')){
            if(is_int($request->input('id_estadocivil'))){
                $data->id_estadocivil=$request->input('id_estadocivil');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estadocivil debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estadocivil no puede estar vacio']], 422);
        }
        if($request->input('id_estatus')){
            if(is_int($request->input('id_estatus'))){
                $data->id_estatus=$request->input('id_estatus');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_estatus debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_estatus no puede estar vacio']], 422);
        }            
        if($request->input('id_antecedentes')){
            if(is_int($request->input('id_antecedentes'))){
                $data->id_antecedentes=$request->input('id_antecedentes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_antecedentes debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_antecedentes no puede estar vacio']], 422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_usuario no puede estar vacio']], 422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error updating Pacienteinfantils'
                ]
            ], 500);
        }
    }
    public function destroyPacienteinfantil($id){
        try
        {
            $data = Pacienteinfantil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pacienteinfantil'
                ]
            ], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error deleting Pacienteinfantil'
                ]
            ], 500);
        }
    }
    public function indexTerapiarespiratoria(){
        try
        {
            $Terapiarespiratorias = Terapiarespiratoria::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Terapiarespiratorias']], 500);
        }
        if($Terapiarespiratorias)
        {
            $data = [];
            foreach($Terapiarespiratorias as $Terapiarespiratoria)
            {
                $types = [];
                $types = [
                    'id' => $Terapiarespiratoria->id,
                    'id_documento' => $Terapiarespiratoria->id_documento,
                    'fecha' => $Terapiarespiratoria->fecha,
                    'id_paciente' => $Terapiarespiratoria->id_paciente,
                    'id_medico' => $Terapiarespiratoria->id_medico,
                    'id_examenfisico' => $Terapiarespiratoria->id_examenfisico,
                    'fisio_terapia_torax' => $Terapiarespiratoria->fisio_terapia_torax,
                    'diagnostico' => $Terapiarespiratoria->diagnostico,
                    'espirometria_incentiva' => $Terapiarespiratoria->espirometria_incentiva,
                    'inhalo_terapia' => $Terapiarespiratoria->inhalo_terapia,
                    'tecnicas_relajacion' => $Terapiarespiratoria->tecnicas_relajacion,
                    'entrenamiento_fisico' => $Terapiarespiratoria->entrenamiento_fisico,
                    'sugerencias' => $Terapiarespiratoria->sugerencias
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Terapiarespiratorias was not found']], 404);
        }
    }
    public function showTerapiarespiratoria($id){
        try
        {
            $Terapiarespiratoria = Terapiarespiratoria::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Terapiarespiratorias']], 500);
        }
        if($Terapiarespiratoria)
        {
            $data = [];
            $data = [
                'id' => $Terapiarespiratoria->id,
                'id_documento' => $Terapiarespiratoria->id_documento,
                'fecha' => $Terapiarespiratoria->fecha,
                'id_paciente' => $Terapiarespiratoria->id_paciente,
                'id_medico' => $Terapiarespiratoria->id_medico,
                'id_examenfisico' => $Terapiarespiratoria->id_examenfisico,
                'fisio_terapia_torax' => $Terapiarespiratoria->fisio_terapia_torax,
                'diagnostico' => $Terapiarespiratoria->diagnostico,
                'espirometria_incentiva' => $Terapiarespiratoria->espirometria_incentiva,
                'inhalo_terapia' => $Terapiarespiratoria->inhalo_terapia,
                'tecnicas_relajacion' => $Terapiarespiratoria->tecnicas_relajacion,
                'entrenamiento_fisico' => $Terapiarespiratoria->entrenamiento_fisico,
                'sugerencias' => $Terapiarespiratoria->sugerencias
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Terapiarespiratoria was not found']], 404);
        }
    }
    public function storeTerapiarespiratoria(Request $request){
        
        $data = new Terapiarespiratoria();
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('fisio_terapia_torax')){
            $data->fisio_terapia_torax = $request->input('fisio_terapia_torax');
        } 
        if($request->input('diagnostico')){
            $data->diagnostico = $request->input('diagnostico');
        } 
        if($request->input('espirometria_incentiva')){
            $data->espirometria_incentiva = $request->input('espirometria_incentiva');
        }
        if($request->input('inhalo_terapia')){
            $data->inhalo_terapia = $request->input('inhalo_terapia');
        }
        if($request->input('tecnicas_relajacion')){
            $data->tecnicas_relajacion = $request->input('tecnicas_relajacion');
        }
        if($request->input('entrenamiento_fisico')){
            $data->entrenamiento_fisico = $request->input('entrenamiento_fisico');
        }
        if($request->input('sugerencias')){
            $data->sugerencias = $request->input('sugerencias');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Terapiarespiratorias']], 500);
        }
    }
    public function updateTerapiarespiratoria($id, Request $request){
        
        try
        {
            $data = Terapiarespiratoria::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Terapiarespiratorias'
                ]
            ], 500);
        }
        if($request->input('id_documento')){
            if(is_int($request->input('id_documento'))){
                $data->id_documento=$request->input('id_documento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_documento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_documento no puede estar vacio']], 422);
        }
        if($request->input('fecha')){
            fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('id_medico')){
            if(is_int($request->input('id_medico'))){
                $data->id_medico=$request->input('id_medico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_medico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_medico no puede estar vacio']], 422);
        }
        if($request->input('id_examenfisico')){
            if(is_int($request->input('id_examenfisico'))){
                $data->id_examenfisico=$request->input('id_examenfisico');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_examenfisico debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_examenfisico no puede estar vacio']], 422);
        }
        if($request->input('fisio_terapia_torax')){
            $data->fisio_terapia_torax = $request->input('fisio_terapia_torax');
        } 
        if($request->input('diagnostico')){
            $data->diagnostico = $request->input('diagnostico');
        } 
        if($request->input('espirometria_incentiva')){
            $data->espirometria_incentiva = $request->input('espirometria_incentiva');
        }
        if($request->input('inhalo_terapia')){
            $data->inhalo_terapia = $request->input('inhalo_terapia');
        }
        if($request->input('tecnicas_relajacion')){
            $data->tecnicas_relajacion = $request->input('tecnicas_relajacion');
        }
        if($request->input('entrenamiento_fisico')){
            $data->entrenamiento_fisico = $request->input('entrenamiento_fisico');
        }
        if($request->input('sugerencias')){
            $data->sugerencias = $request->input('sugerencias');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Terapiarespiratorias']], 500);
        }
    }
    public function destroyTerapiarespiratoria($id){
        try
        {
            $data = Terapiarespiratoria::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Terapiarespiratoria']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Terapiarespiratoria']], 500);
        }
    }
    public function indexHerencia(){
        try
        {
            $Herencias = Herencia::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Herencias']], 500);
        }
        if($Herencias)
        {
            $data = [];
            foreach($Herencias as $Herencia)
            {
                $types = [];
                $types = [
                    'id' => $Herencia->id,
                    'id_paciente' => $Herencia->id_paciente,
                    'padre' => $Herencia->padre,
                    'madre' => $Herencia->madre,
                    'hermanos' => $Herencia->hermanos,
                    'observaciones' => $Herencia->observaciones
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Herencias was not found']], 404);
        }
    }
    public function showHerencia($id){
        try
        {
            $Herencia = Herencia::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Herencias']], 500);
        }
        if($Herencia)
        {
            $data = [];
            $data = [
                'id' => $Herencia->id,
                'id_paciente' => $Herencia->id_paciente,
                'padre' => $Herencia->padre,
                'madre' => $Herencia->madre,
                'hermanos' => $Herencia->hermanos,
                'observaciones' => $Herencia->observaciones
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Herencia was not found']], 404);
        }
    }
    public function storeHerencia(Request $request){
        
        $data = new Herencia();
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('padre')){
            $data->padre = $request->input('padre');
        }
        if($request->input('madre')){
            $data->madre = $request->input('madre');
        }
        if($request->input('hermanos')){
            $data->hermanos = $request->input('hermanos');
        }
        if($request->input('observaciones')){
            $data->observaciones = $request->input('observaciones');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Herencias']], 500);
        }
    }
    public function updateHerencia($id, Request $request){
        
        try
        {
            $data = Herencia::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Herencias'
                ]
            ], 500);
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('padre')){
            $data->padre = $request->input('padre');
        }
        if($request->input('madre')){
            $data->madre = $request->input('madre');
        }
        if($request->input('hermanos')){
            $data->hermanos = $request->input('hermanos');
        }
        if($request->input('observaciones')){
            $data->observaciones = $request->input('observaciones');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Herencias']], 500);
        }
    }
    public function destroyHerencia($id){
        try
        {
            $data = Herencia::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Herencia']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Herencia']], 500);
        }
    }
    public function indexAntecedentes(){
        try
        {
            $Antecedentess = Antecedentes::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Antecedentess']], 500);
        }
        if($Antecedentess)
        {
            $data = [];
            foreach($Antecedentess as $Antecedentes)
            {
                $types = [];
                $types = [
                    'id' => $Antecedentes->id,
                    'diabetes' => $Antecedentes->diabetes,
                    'dislipidemias' => $Antecedentes->dislipidemias,
                    'tabaquismo' => $Antecedentes->tabaquismo,
                    'sedentarismo' => $Antecedentes->sedentarismo,
                    'obesidad' => $Antecedentes->obesidad,
                    'diagnosticoeac' => $Antecedentes->diagnosticoeac,
                    'angina' => $Antecedentes->angina,
                    'cf' => $Antecedentes->cf,
                    'im' => $Antecedentes->im,
                    'angioplastia' => $Antecedentes->angioplastia,
                    'cirugia' => $Antecedentes->cirugia,
                    'arritmias' => $Antecedentes->arritmias,
                    'sv' => $Antecedentes->sv,
                    'bloqueoav' => $Antecedentes->bloqueoav,
                    'mpd' => $Antecedentes->mpd,
                    'acv' => $Antecedentes->acv,
                    'enfcaritidea' => $Antecedentes->enfcaritidea,
                    'enfperiferica' => $Antecedentes->enfperiferica,
                    'cardreumatica' => $Antecedentes->cardreumatica,
                    'id_paciente' => $Antecedentes->id_paciente,
                    'observaciones' => $Antecedentes->observaciones
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Antecedentess was not found']], 404);
        }
    }
    public function showAntecedentes($id){
        try
        {
            $Antecedentes = Antecedentes::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Antecedentess']], 500);
        }
        if($Antecedentes)
        {
            $data = [];
            $data = [
                'id' => $Antecedentes->id,
                'diabetes' => $Antecedentes->diabetes,
                'dislipidemias' => $Antecedentes->dislipidemias,
                'tabaquismo' => $Antecedentes->tabaquismo,
                'sedentarismo' => $Antecedentes->sedentarismo,
                'obesidad' => $Antecedentes->obesidad,
                'diagnosticoeac' => $Antecedentes->diagnosticoeac,
                'angina' => $Antecedentes->angina,
                'cf' => $Antecedentes->cf,
                'im' => $Antecedentes->im,
                'angioplastia' => $Antecedentes->angioplastia,
                'cirugia' => $Antecedentes->cirugia,
                'arritmias' => $Antecedentes->arritmias,
                'sv' => $Antecedentes->sv,
                'bloqueoav' => $Antecedentes->bloqueoav,
                'mpd' => $Antecedentes->mpd,
                'acv' => $Antecedentes->acv,
                'enfcaritidea' => $Antecedentes->enfcaritidea,
                'enfperiferica' => $Antecedentes->enfperiferica,
                'cardreumatica' => $Antecedentes->cardreumatica,
                'id_paciente' => $Antecedentes->id_paciente,
                'observaciones' => $Antecedentes->observaciones
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Antecedentes was not found']], 404);
        }
    }
    public function storeAntecedentes(Request $request){
        
        $data = new Antecedentes();
        if($request->input('diabetes')){
            if(is_int($request->input('diabetes'))){
                $data->diabetes=$request->input('diabetes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'diabetes debe ser numero entero']],422);
            }
        }
        if($request->input('dislipidemias')){
            if(is_int($request->input('dislipidemias'))){
                $data->dislipidemias=$request->input('dislipidemias');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'dislipidemias debe ser numero entero']],422);
            }
        }
        if($request->input('tabaquismo')){
            if(is_int($request->input('tabaquismo'))){
                $data->tabaquismo=$request->input('tabaquismo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'tabaquismo debe ser numero entero']],422);
            }
        }
        if($request->input('sedentarismo')){
            if(is_int($request->input('sedentarismo'))){
                $data->sedentarismo=$request->input('sedentarismo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'sedentarismo debe ser numero entero']],422);
            }
        }
        if($request->input('obesidad')){
            if(is_int($request->input('obesidad'))){
                $data->obesidad=$request->input('obesidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'obesidad debe ser numero entero']],422);
            }
        }
        if($request->input('diagnosticoeac')){
            if(is_int($request->input('diagnosticoeac'))){
                $data->diagnosticoeac=$request->input('diagnosticoeac');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'diagnosticoeac debe ser numero entero']],422);
            }
        }
        if($request->input('angina')){
            if(is_int($request->input('angina'))){
                $data->angina=$request->input('angina');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'angina debe ser numero entero']],422);
            }
        }
        if($request->input('cf')){
            if(is_int($request->input('cf'))){
                $data->cf=$request->input('cf');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cf debe ser numero entero']],422);
            }
        }
        if($request->input('im')){
            if(is_int($request->input('im'))){
                $data->im=$request->input('im');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'im debe ser numero entero']],422);
            }
        }
        if($request->input('angioplastia')){
            if(is_int($request->input('angioplastia'))){
                $data->angioplastia=$request->input('angioplastia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'angioplastia debe ser numero entero']],422);
            }
        }
        if($request->input('cirugia')){
            if(is_int($request->input('cirugia'))){
                $data->cirugia=$request->input('cirugia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cirugia debe ser numero entero']],422);
            }
        }
        if($request->input('arritmias')){
            if(is_int($request->input('arritmias'))){
                $data->arritmias=$request->input('arritmias');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'arritmias debe ser numero entero']],422);
            }
        }
        if($request->input('sv')){
            if(is_int($request->input('sv'))){
                $data->sv=$request->input('sv');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'sv debe ser numero entero']],422);
            }
        }
        if($request->input('bloqueoav')){
            if(is_int($request->input('bloqueoav'))){
                $data->bloqueoav=$request->input('bloqueoav');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'bloqueoav debe ser numero entero']],422);
            }
        }
        if($request->input('mpd')){
            if(is_int($request->input('mpd'))){
                $data->mpd=$request->input('mpd');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'mpd debe ser numero entero']],422);
            }
        }
        if($request->input('acv')){
            if(is_int($request->input('acv'))){
                $data->acv=$request->input('acv');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'acv debe ser numero entero']],422);
            }
        }
        if($request->input('enfcaritidea')){
            if(is_int($request->input('enfcaritidea'))){
                $data->enfcaritidea=$request->input('enfcaritidea');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'enfcaritidea debe ser numero entero']],422);
            }
        }
        if($request->input('enfperiferica')){
            if(is_int($request->input('enfperiferica'))){
                $data->enfperiferica=$request->input('enfperiferica');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'enfperiferica debe ser numero entero']],422);
            }
        }
        if($request->input('cardreumatica')){
            if(is_int($request->input('cardreumatica'))){
                $data->cardreumatica=$request->input('cardreumatica');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cardreumatica debe ser numero entero']],422);
            }
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('observaciones')){
            $data->observaciones = $request->input('observaciones');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Antecedentess']], 500);
        }
    }
    public function updateAntecedentes($id, Request $request){
        
        try
        {
            $data = Antecedentes::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Antecedentess'
                ]
            ], 500);
        }
        if($request->input('diabetes')){
            if(is_int($request->input('diabetes'))){
                $data->diabetes=$request->input('diabetes');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'diabetes debe ser numero entero']],422);
            }
        }
        if($request->input('dislipidemias')){
            if(is_int($request->input('dislipidemias'))){
                $data->dislipidemias=$request->input('dislipidemias');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'dislipidemias debe ser numero entero']],422);
            }
        }
        if($request->input('tabaquismo')){
            if(is_int($request->input('tabaquismo'))){
                $data->tabaquismo=$request->input('tabaquismo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'tabaquismo debe ser numero entero']],422);
            }
        }
        if($request->input('sedentarismo')){
            if(is_int($request->input('sedentarismo'))){
                $data->sedentarismo=$request->input('sedentarismo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'sedentarismo debe ser numero entero']],422);
            }
        }
        if($request->input('obesidad')){
            if(is_int($request->input('obesidad'))){
                $data->obesidad=$request->input('obesidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'obesidad debe ser numero entero']],422);
            }
        }
        if($request->input('diagnosticoeac')){
            if(is_int($request->input('diagnosticoeac'))){
                $data->diagnosticoeac=$request->input('diagnosticoeac');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'diagnosticoeac debe ser numero entero']],422);
            }
        }
        if($request->input('angina')){
            if(is_int($request->input('angina'))){
                $data->angina=$request->input('angina');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'angina debe ser numero entero']],422);
            }
        }
        if($request->input('cf')){
            if(is_int($request->input('cf'))){
                $data->cf=$request->input('cf');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cf debe ser numero entero']],422);
            }
        }
        if($request->input('im')){
            if(is_int($request->input('im'))){
                $data->im=$request->input('im');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'im debe ser numero entero']],422);
            }
        }
        if($request->input('angioplastia')){
            if(is_int($request->input('angioplastia'))){
                $data->angioplastia=$request->input('angioplastia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'angioplastia debe ser numero entero']],422);
            }
        }
        if($request->input('cirugia')){
            if(is_int($request->input('cirugia'))){
                $data->cirugia=$request->input('cirugia');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cirugia debe ser numero entero']],422);
            }
        }
        if($request->input('arritmias')){
            if(is_int($request->input('arritmias'))){
                $data->arritmias=$request->input('arritmias');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'arritmias debe ser numero entero']],422);
            }
        }
        if($request->input('sv')){
            if(is_int($request->input('sv'))){
                $data->sv=$request->input('sv');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'sv debe ser numero entero']],422);
            }
        }
        if($request->input('bloqueoav')){
            if(is_int($request->input('bloqueoav'))){
                $data->bloqueoav=$request->input('bloqueoav');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'bloqueoav debe ser numero entero']],422);
            }
        }
        if($request->input('mpd')){
            if(is_int($request->input('mpd'))){
                $data->mpd=$request->input('mpd');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'mpd debe ser numero entero']],422);
            }
        }
        if($request->input('acv')){
            if(is_int($request->input('acv'))){
                $data->acv=$request->input('acv');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'acv debe ser numero entero']],422);
            }
        }
        if($request->input('enfcaritidea')){
            if(is_int($request->input('enfcaritidea'))){
                $data->enfcaritidea=$request->input('enfcaritidea');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'enfcaritidea debe ser numero entero']],422);
            }
        }
        if($request->input('enfperiferica')){
            if(is_int($request->input('enfperiferica'))){
                $data->enfperiferica=$request->input('enfperiferica');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'enfperiferica debe ser numero entero']],422);
            }
        }
        if($request->input('cardreumatica')){
            if(is_int($request->input('cardreumatica'))){
                $data->cardreumatica=$request->input('cardreumatica');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'cardreumatica debe ser numero entero']],422);
            }
        }
        if($request->input('id_paciente')){
            if(is_int($request->input('id_paciente'))){
                $data->id_paciente=$request->input('id_paciente');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => [
                      'errorCode' => '008','error' => 'id_paciente debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('observaciones')){
            $data->observaciones = $request->input('observaciones');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Antecedentess']], 500);
        }
    }
    public function destroyAntecedentes($id){
        try
        {
            $data = Antecedentes::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Antecedentes']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Antecedentes']], 500);
        }
    }
    public function indexLaboratorio(){
        try
        {
            $Laboratorios = Laboratorio::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Laboratorios']], 500);
        }
        if($Laboratorios)
        {
            $data = [];
            foreach($Laboratorios as $Laboratorio)
            {
                $types = [];
                $types = [
                    'id' => $Laboratorio->id,
                    'fecha' => $Laboratorio->fecha,
                    'id_paciente' => $Laboratorio->id_paciente,
                    'ACIDO_URICO_SERICO' => $Laboratorio->ACIDO_URICO_SERICO,
                    'ASTO' => $Laboratorio->ASTO,
                    'BILIRUBINA_TOTAL_FRACCI' => $Laboratorio->BILIRUBINA_TOTAL_FRACCI,
                    'CALCIO_SERICO' => $Laboratorio->CALCIO_SERICO,
                    'COLESTEROL' => $Laboratorio->COLESTEROL,
                    'CREATININA' => $Laboratorio->CREATININA,
                    'CURVA_DE_TOLERANCIA_GLUC' => $Laboratorio->CURVA_DE_TOLERANCIA_GLUC,
                    'DEPURACION_DE_CREATININA' => $Laboratorio->DEPURACION_DE_CREATININA,
                    'EMBARAZO_EN_SANGRE' => $Laboratorio->EMBARAZO_EN_SANGRE,
                    'ENZIMA_CARDIACA_CK' => $Laboratorio->ENZIMA_CARDIACA_CK,
                    'ENZIMA_CARDIACA_CKMB' => $Laboratorio->ENZIMA_CARDIACA_CKMB,
                    'ENZIMA_CARDIACA_LDH' => $Laboratorio->ENZIMA_CARDIACA_LDH,
                    'FOSFATASA_ACIDA' => $Laboratorio->FOSFATASA_ACIDA,
                    'FOSFATASA_ALCALINA' => $Laboratorio->FOSFATASA_ALCALINA,
                    'FOSFORO' => $Laboratorio->FOSFORO,
                    'GLICEMIA' => $Laboratorio->GLICEMIA,
                    'ACIDO_URICO_EN_ORINA' => $Laboratorio->ACIDO_URICO_EN_ORINA,
                    'GRUPO_SANGUINEO' => $Laboratorio->GRUPO_SANGUINEO,
                    'HDL_LDL' => $Laboratorio->HDL_LDL,
                    'HECES' => $Laboratorio->HECES,
                    'HEMATOLOGIA_COMPLETA' => $Laboratorio->HEMATOLOGIA_COMPLETA,
                    'HIERRO' => $Laboratorio->HIERRO,
                    'HIV' => $Laboratorio->HIV,
                    'ORINA' => $Laboratorio->ORINA,
                    'PSA_TOTAL' => $Laboratorio->PSA_TOTAL,
                    'PTT' => $Laboratorio->PTT,
                    'PLAQUETAS' => $Laboratorio->PLAQUETAS,
                    'PROTEINA_C_REACTIVA' => $Laboratorio->PROTEINA_C_REACTIVA,
                    'PROTEINAS_TOTAL_FRACCION' => $Laboratorio->PROTEINAS_TOTAL_FRACCION,
                    'RA_TEST' => $Laboratorio->RA_TEST,
                    'ORINA' => $Laboratorio->ORINA,
                    'REL_CALCIO_CREATININA_EN' => $Laboratorio->REL_CALCIO_CREATININA_EN,
                    'RETICULOCITOS' => $Laboratorio->RETICULOCITOS,
                    'SANGRE_OCULTA_EN_HECES' => $Laboratorio->SANGRE_OCULTA_EN_HECES,
                    'TIEMPO_DE_PROTOMBINA' => $Laboratorio->TIEMPO_DE_PROTOMBINA,
                    'TIEMPO_SANGRIA_COAGULACION' => $Laboratorio->TIEMPO_SANGRIA_COAGULACION,
                    'TRANSAMINASA_TGO' => $Laboratorio->TRANSAMINASA_TGO,
                    'TRANSAMINASA_TGP' => $Laboratorio->TRANSAMINASA_TGP,
                    'TRANSAMINASA_TGOTGP' => $Laboratorio->TRANSAMINASA_TGOTGP,
                    'TRIGLICERIDOS' => $Laboratorio->TRIGLICERIDOS,
                    'UREA' => $Laboratorio->UREA,
                    'VDRL' => $Laboratorio->VDRL,
                    'VELOCIDAD_SED_GLOBULAR' => $Laboratorio->VELOCIDAD_SED_GLOBULAR,
                    'VLDL' => $Laboratorio->VLDL,
                    'CALCIO_EN_ORINA' => $Laboratorio->CALCIO_EN_ORINA,
                    'PROTEINURIA_EN_ORINA_24' => $Laboratorio->PROTEINURIA_EN_ORINA_24,
                    'TROPONINA' => $Laboratorio->TROPONINA,
                    'GASES_ARTERIALES' => $Laboratorio->GASES_ARTERIALES,
                    'GASES_VENENOSOS' => $Laboratorio->GASES_VENENOSOS,
                    'EMBARAZO_EN_ORINA' => $Laboratorio->EMBARAZO_EN_ORINA,
                    'ELECTROLITOS' => $Laboratorio->ELECTROLITOS,
                    'AMILASA' => $Laboratorio->AMILASA,
                    'MAGNESIO' => $Laboratorio->MAGNESIO,
                    'GRAM' => $Laboratorio->GRAM,
                    'CETONEMIA' => $Laboratorio->CETONEMIA,
                    'DIGOXINA' => $Laboratorio->DIGOXINA,
                    'T3' => $Laboratorio->T3,
                    'T4' => $Laboratorio->T4,
                    'TSH' => $Laboratorio->TSH,
                    'T3LIBRE' => $Laboratorio->T3LIBRE,
                    'T4LIBRE' => $Laboratorio->T4LIBRE,
                    'FIBRINOGENO' => $Laboratorio->FIBRINOGENO,
                    'RELUREA_REATININA_EN_O' => $Laboratorio->RELUREA_REATININA_EN_O,
                    'REL_ACIDO_URICO_CREATININA' => $Laboratorio->REL_ACIDO_URICO_CREATININA,
                    'REL_FOSFORO_CREATININA' => $Laboratorio->REL_FOSFORO_CREATININA,
                    'REL_AMILASA_CREATININA_E' => $Laboratorio->REL_AMILASA_CREATININA_E,
                    'UREA_EN_ORINA' => $Laboratorio->UREA_EN_ORINA,
                    'PROTEINAS_EN_ORINA' => $Laboratorio->PROTEINAS_EN_ORINA,
                    'FOSFORO_EN_ORINA' => $Laboratorio->FOSFORO_EN_ORINA,
                    'AMILASA_EN_ORINA' => $Laboratorio->AMILASA_EN_ORINA,
                    'MAGNESIO_EN_ORINA' => $Laboratorio->MAGNESIO_EN_ORINA,
                    'REL_PROTEINA_CREATININA' => $Laboratorio->REL_PROTEINA_CREATININA,
                    'FROTIS_DE_SANGRE_PERIFERICO' => $Laboratorio->FROTIS_DE_SANGRE_PERIFERICO,
                    'DENGUE_DUO' => $Laboratorio->DENGUE_DUO,
                    'ESTRADIOL' => $Laboratorio->ESTRADIOL,
                    'FSH' => $Laboratorio->FSH,
                    'LH' => $Laboratorio->LH,
                    'PSA_LIBRE' => $Laboratorio->PSA_LIBRE,
                    'ANTIGENO_DE_SUPERFICIE' => $Laboratorio->ANTIGENO_DE_SUPERFICIE,
                    'CORE_TOTAL' => $Laboratorio->CORE_TOTAL,
                    'CORE_M' => $Laboratorio->CORE_M,
                    'TOXO_M' => $Laboratorio->TOXO_M,
                    'TOXO_G' => $Laboratorio->TOXO_G,
                    'GLICEMIA_POST_PRANDIAL' => $Laboratorio->GLICEMIA_POST_PRANDIAL,
                    'INSULINA_BASAL' => $Laboratorio->INSULINA_BASAL,
                    'HEMOGLOBINA_GLICOSILADA' => $Laboratorio->HEMOGLOBINA_GLICOSILADA,
                    'TROPONINA_T' => $Laboratorio->TROPONINA_T,
                    'GANMAGLUTAMINA_GGT' => $Laboratorio->GANMAGLUTAMINA_GGT,
                    'DIMERO_D' => $Laboratorio->DIMERO_D,
                    'MICROALBUMINURIA' => $Laboratorio->MICROALBUMINURIA,
                    'PEPTIDO_NATRIURETICO' => $Laboratorio->PEPTIDO_NATRIURETICO,
                    'MIOGLOBINA' => $Laboratorio->MIOGLOBINA,
                    'MONONUCLEOSIS_INFECCIOSA' => $Laboratorio->MONONUCLEOSIS_INFECCIOSA,
                    'HEPATITIS_B_CORE' => $Laboratorio->HEPATITIS_B_CORE,
                    'HEPATITIS_B_SUPERFICIE' => $Laboratorio->HEPATITIS_B_SUPERFICIE,
                    'HEPATITIS_C_VIRUS_HCV' => $Laboratorio->HEPATITIS_C_VIRUS_HCV,
                    'HELICOBACTER_PILORI' => $Laboratorio->HELICOBACTER_PILORI
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Laboratorios was not found']], 404);
        }
    }
    public function showLaboratorio($id){
        try
        {
            $Laboratorio = Laboratorio::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Laboratorios']], 500);
        }
        if($Laboratorio)
        {
            $data = [];
            $data = [
                'id' => $Laboratorio->id,
                'fecha' => $Laboratorio->fecha,
                'id_paciente' => $Laboratorio->id_paciente,
                'ACIDO_URICO_SERICO' => $Laboratorio->ACIDO_URICO_SERICO,
                'ASTO' => $Laboratorio->ASTO,
                'BILIRUBINA_TOTAL_FRACCI' => $Laboratorio->BILIRUBINA_TOTAL_FRACCI,
                'CALCIO_SERICO' => $Laboratorio->CALCIO_SERICO,
                'COLESTEROL' => $Laboratorio->COLESTEROL,
                'CREATININA' => $Laboratorio->CREATININA,
                'CURVA_DE_TOLERANCIA_GLUC' => $Laboratorio->CURVA_DE_TOLERANCIA_GLUC,
                'DEPURACION_DE_CREATININA' => $Laboratorio->DEPURACION_DE_CREATININA,
                'EMBARAZO_EN_SANGRE' => $Laboratorio->EMBARAZO_EN_SANGRE,
                'ENZIMA_CARDIACA_CK' => $Laboratorio->ENZIMA_CARDIACA_CK,
                'ENZIMA_CARDIACA_CKMB' => $Laboratorio->ENZIMA_CARDIACA_CKMB,
                'ENZIMA_CARDIACA_LDH' => $Laboratorio->ENZIMA_CARDIACA_LDH,
                'FOSFATASA_ACIDA' => $Laboratorio->FOSFATASA_ACIDA,
                'FOSFATASA_ALCALINA' => $Laboratorio->FOSFATASA_ALCALINA,
                'FOSFORO' => $Laboratorio->FOSFORO,
                'GLICEMIA' => $Laboratorio->GLICEMIA,
                'ACIDO_URICO_EN_ORINA' => $Laboratorio->ACIDO_URICO_EN_ORINA,
                'GRUPO_SANGUINEO' => $Laboratorio->GRUPO_SANGUINEO,
                'HDL_LDL' => $Laboratorio->HDL_LDL,
                'HECES' => $Laboratorio->HECES,
                'HEMATOLOGIA_COMPLETA' => $Laboratorio->HEMATOLOGIA_COMPLETA,
                'HIERRO' => $Laboratorio->HIERRO,
                'HIV' => $Laboratorio->HIV,
                'ORINA' => $Laboratorio->ORINA,
                'PSA_TOTAL' => $Laboratorio->PSA_TOTAL,
                'PTT' => $Laboratorio->PTT,
                'PLAQUETAS' => $Laboratorio->PLAQUETAS,
                'PROTEINA_C_REACTIVA' => $Laboratorio->PROTEINA_C_REACTIVA,
                'PROTEINAS_TOTAL_FRACCION' => $Laboratorio->PROTEINAS_TOTAL_FRACCION,
                'RA_TEST' => $Laboratorio->RA_TEST,
                'ORINA' => $Laboratorio->ORINA,
                'REL_CALCIO_CREATININA_EN' => $Laboratorio->REL_CALCIO_CREATININA_EN,
                'RETICULOCITOS' => $Laboratorio->RETICULOCITOS,
                'SANGRE_OCULTA_EN_HECES' => $Laboratorio->SANGRE_OCULTA_EN_HECES,
                'TIEMPO_DE_PROTOMBINA' => $Laboratorio->TIEMPO_DE_PROTOMBINA,
                'TIEMPO_SANGRIA_COAGULACION' => $Laboratorio->TIEMPO_SANGRIA_COAGULACION,
                'TRANSAMINASA_TGO' => $Laboratorio->TRANSAMINASA_TGO,
                'TRANSAMINASA_TGP' => $Laboratorio->TRANSAMINASA_TGP,
                'TRANSAMINASA_TGOTGP' => $Laboratorio->TRANSAMINASA_TGOTGP,
                'TRIGLICERIDOS' => $Laboratorio->TRIGLICERIDOS,
                'UREA' => $Laboratorio->UREA,
                'VDRL' => $Laboratorio->VDRL,
                'VELOCIDAD_SED_GLOBULAR' => $Laboratorio->VELOCIDAD_SED_GLOBULAR,
                'VLDL' => $Laboratorio->VLDL,
                'CALCIO_EN_ORINA' => $Laboratorio->CALCIO_EN_ORINA,
                'PROTEINURIA_EN_ORINA_24' => $Laboratorio->PROTEINURIA_EN_ORINA_24,
                'TROPONINA' => $Laboratorio->TROPONINA,
                'GASES_ARTERIALES' => $Laboratorio->GASES_ARTERIALES,
                'GASES_VENENOSOS' => $Laboratorio->GASES_VENENOSOS,
                'EMBARAZO_EN_ORINA' => $Laboratorio->EMBARAZO_EN_ORINA,
                'ELECTROLITOS' => $Laboratorio->ELECTROLITOS,
                'AMILASA' => $Laboratorio->AMILASA,
                'MAGNESIO' => $Laboratorio->MAGNESIO,
                'GRAM' => $Laboratorio->GRAM,
                'CETONEMIA' => $Laboratorio->CETONEMIA,
                'DIGOXINA' => $Laboratorio->DIGOXINA,
                'T3' => $Laboratorio->T3,
                'T4' => $Laboratorio->T4,
                'TSH' => $Laboratorio->TSH,
                'T3LIBRE' => $Laboratorio->T3LIBRE,
                'T4LIBRE' => $Laboratorio->T4LIBRE,
                'FIBRINOGENO' => $Laboratorio->FIBRINOGENO,
                'RELUREA_REATININA_EN_O' => $Laboratorio->RELUREA_REATININA_EN_O,
                'REL_ACIDO_URICO_CREATININA' => $Laboratorio->REL_ACIDO_URICO_CREATININA,
                'REL_FOSFORO_CREATININA' => $Laboratorio->REL_FOSFORO_CREATININA,
                'REL_AMILASA_CREATININA_E' => $Laboratorio->REL_AMILASA_CREATININA_E,
                'UREA_EN_ORINA' => $Laboratorio->UREA_EN_ORINA,
                'PROTEINAS_EN_ORINA' => $Laboratorio->PROTEINAS_EN_ORINA,
                'FOSFORO_EN_ORINA' => $Laboratorio->FOSFORO_EN_ORINA,
                'AMILASA_EN_ORINA' => $Laboratorio->AMILASA_EN_ORINA,
                'MAGNESIO_EN_ORINA' => $Laboratorio->MAGNESIO_EN_ORINA,
                'REL_PROTEINA_CREATININA' => $Laboratorio->REL_PROTEINA_CREATININA,
                'FROTIS_DE_SANGRE_PERIFERICO' => $Laboratorio->FROTIS_DE_SANGRE_PERIFERICO,
                'DENGUE_DUO' => $Laboratorio->DENGUE_DUO,
                'ESTRADIOL' => $Laboratorio->ESTRADIOL,
                'FSH' => $Laboratorio->FSH,
                'LH' => $Laboratorio->LH,
                'PSA_LIBRE' => $Laboratorio->PSA_LIBRE,
                'ANTIGENO_DE_SUPERFICIE' => $Laboratorio->ANTIGENO_DE_SUPERFICIE,
                'CORE_TOTAL' => $Laboratorio->CORE_TOTAL,
                'CORE_M' => $Laboratorio->CORE_M,
                'TOXO_M' => $Laboratorio->TOXO_M,
                'TOXO_G' => $Laboratorio->TOXO_G,
                'GLICEMIA_POST_PRANDIAL' => $Laboratorio->GLICEMIA_POST_PRANDIAL,
                'INSULINA_BASAL' => $Laboratorio->INSULINA_BASAL,
                'HEMOGLOBINA_GLICOSILADA' => $Laboratorio->HEMOGLOBINA_GLICOSILADA,
                'TROPONINA_T' => $Laboratorio->TROPONINA_T,
                'GANMAGLUTAMINA_GGT' => $Laboratorio->GANMAGLUTAMINA_GGT,
                'DIMERO_D' => $Laboratorio->DIMERO_D,
                'MICROALBUMINURIA' => $Laboratorio->MICROALBUMINURIA,
                'PEPTIDO_NATRIURETICO' => $Laboratorio->PEPTIDO_NATRIURETICO,
                'MIOGLOBINA' => $Laboratorio->MIOGLOBINA,
                'MONONUCLEOSIS_INFECCIOSA' => $Laboratorio->MONONUCLEOSIS_INFECCIOSA,
                'HEPATITIS_B_CORE' => $Laboratorio->HEPATITIS_B_CORE,
                'HEPATITIS_B_SUPERFICIE' => $Laboratorio->HEPATITIS_B_SUPERFICIE,
                'HEPATITIS_C_VIRUS_HCV' => $Laboratorio->HEPATITIS_C_VIRUS_HCV,
                'HELICOBACTER_PILORI' => $Laboratorio->HELICOBACTER_PILORI
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Laboratorio was not found']], 404);
        }
    }
    public function storeLaboratorio(Request $request){
        
        $data = new Laboratorio();
        if($request->input('fecha')){
            $data->fecha = $request->input('nombre');
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            $data->id_paciente = $request->input('nombre');
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('ACIDO_URICO_SERICO')){
            $data->ACIDO_URICO_SERICO = $request->input('ACIDO_URICO_SERICO');
        }
        if($request->input('ASTO')){
            $data->ASTO = $request->input('ASTO');
        }
        if($request->input('BILIRUBINA_TOTAL_FRACCI')){
            $data->BILIRUBINA_TOTAL_FRACCI = $request->input('BILIRUBINA_TOTAL_FRACCI');
        }
        if($request->input('CALCIO_SERICO')){
            $data->CALCIO_SERICO = $request->input('CALCIO_SERICO');
        }
        if($request->input('COLESTEROL')){
            $data->COLESTEROL = $request->input('COLESTEROL');
        }
        if($request->input('CREATININA')){
            $data->CREATININA = $request->input('CREATININA');
        }
        if($request->input('CURVA_DE_TOLERANCIA_GLUC')){
            $data->CURVA_DE_TOLERANCIA_GLUC = $request->input('CURVA_DE_TOLERANCIA_GLUC');
        }
        if($request->input('DEPURACION_DE_CREATININA')){
            $data->DEPURACION_DE_CREATININA = $request->input('DEPURACION_DE_CREATININA');
        }
        if($request->input('EMBARAZO_EN_SANGRE')){
            $data->EMBARAZO_EN_SANGRE = $request->input('EMBARAZO_EN_SANGRE');
        }
        if($request->input('ENZIMA_CARDIACA_CK')){
            $data->ENZIMA_CARDIACA_CK = $request->input('ENZIMA_CARDIACA_CK');
        }
        if($request->input('ENZIMA_CARDIACA_CKMB')){
            $data->ENZIMA_CARDIACA_CKMB = $request->input('ENZIMA_CARDIACA_CKMB');
        }
        if($request->input('ENZIMA_CARDIACA_LDH')){
            $data->ENZIMA_CARDIACA_LDH = $request->input('ENZIMA_CARDIACA_LDH');
        }
        if($request->input('FOSFATASA_ACIDA')){
            $data->FOSFATASA_ACIDA = $request->input('FOSFATASA_ACIDA');
        }
        if($request->input('FOSFATASA_ALCALINA')){
            $data->FOSFATASA_ALCALINA = $request->input('FOSFATASA_ALCALINA');
        }
        if($request->input('FOSFORO')){
            $data->FOSFORO = $request->input('FOSFORO');
        }
        if($request->input('GLICEMIA')){
            $data->GLICEMIA = $request->input('GLICEMIA');
        }
        if($request->input('ACIDO_URICO_EN_ORINA')){
            $data->ACIDO_URICO_EN_ORINA = $request->input('ACIDO_URICO_EN_ORINA');
        }
        if($request->input('GRUPO_SANGUINEO')){
            $data->GRUPO_SANGUINEO = $request->input('GRUPO_SANGUINEO');
        }
        if($request->input('HDL_LDL')){
            $data->HDL_LDL = $request->input('HDL_LDL');
        }
        if($request->input('HECES')){
            $data->HECES = $request->input('HECES');
        }
        if($request->input('HEMATOLOGIA_COMPLETA')){
            $data->HEMATOLOGIA_COMPLETA = $request->input('HEMATOLOGIA_COMPLETA');
        }
        if($request->input('HIERRO')){
            $data->HIERRO = $request->input('HIERRO');
        }
        if($request->input('HIV')){
            $data->HIV = $request->input('HIV');
        }
        if($request->input('ORINA')){
            $data->ORINA = $request->input('ORINA');
        }
        if($request->input('PSA_TOTAL')){
            $data->PSA_TOTAL = $request->input('PSA_TOTAL');
        }
        if($request->input('PTT')){
            $data->PTT = $request->input('PTT');
        }
        if($request->input('PLAQUETAS')){
            $data->PLAQUETAS = $request->input('PLAQUETAS');
        }
        if($request->input('PROTEINA_C_REACTIVA')){
            $data->PROTEINA_C_REACTIVA = $request->input('PROTEINA_C_REACTIVA');
        }
        if($request->input('PROTEINAS_TOTAL_FRACCION')){
            $data->PROTEINAS_TOTAL_FRACCION = $request->input('PROTEINAS_TOTAL_FRACCION');
        }
        if($request->input('RA_TEST')){
            $data->RA_TEST = $request->input('RA_TEST');
        }
        if($request->input('ORINA')){
            $data->ORINA = $request->input('ORINA');
        }
        if($request->input('REL_CALCIO_CREATININA_EN')){
            $data->REL_CALCIO_CREATININA_EN = $request->input('REL_CALCIO_CREATININA_EN');
        }
        if($request->input('RETICULOCITOS')){
            $data->RETICULOCITOS = $request->input('RETICULOCITOS');
        }
        if($request->input('SANGRE_OCULTA_EN_HECES')){
            $data->SANGRE_OCULTA_EN_HECES = $request->input('SANGRE_OCULTA_EN_HECES');
        }
        if($request->input('TIEMPO_DE_PROTOMBINA')){
            $data->TIEMPO_DE_PROTOMBINA = $request->input('TIEMPO_DE_PROTOMBINA');
        }
        if($request->input('TIEMPO_SANGRIA_COAGULACION')){
            $data->TIEMPO_SANGRIA_COAGULACION = $request->input('TIEMPO_SANGRIA_COAGULACION');
        }
        if($request->input('TRANSAMINASA_TGO')){
            $data->TRANSAMINASA_TGO = $request->input('TRANSAMINASA_TGO');
        }
        if($request->input('TRANSAMINASA_TGP')){
            $data->TRANSAMINASA_TGP = $request->input('TRANSAMINASA_TGP');
        }
        if($request->input('TRANSAMINASA_TGOTGP')){
            $data->TRANSAMINASA_TGOTGP = $request->input('TRANSAMINASA_TGOTGP');
        }
        if($request->input('TRIGLICERIDOS')){
            $data->TRIGLICERIDOS = $request->input('TRIGLICERIDOS');
        }
        if($request->input('UREA')){
            $data->UREA = $request->input('UREA');
        }
        if($request->input('VDRL')){
            $data->VDRL = $request->input('VDRL');
        }
        if($request->input('VELOCIDAD_SED_GLOBULAR')){
            $data->VELOCIDAD_SED_GLOBULAR = $request->input('VELOCIDAD_SED_GLOBULAR');
        }
        if($request->input('VLDL')){
            $data->VLDL = $request->input('VLDL');
        }
        if($request->input('CALCIO_EN_ORINA')){
            $data->CALCIO_EN_ORINA = $request->input('CALCIO_EN_ORINA');
        }
        if($request->input('PROTEINURIA_EN_ORINA_24')){
            $data->PROTEINURIA_EN_ORINA_24 = $request->input('PROTEINURIA_EN_ORINA_24');
        }
        if($request->input('TROPONINA')){
            $data->TROPONINA = $request->input('TROPONINA');
        }
        if($request->input('GASES_ARTERIALES')){
            $data->GASES_ARTERIALES = $request->input('GASES_ARTERIALES');
        }
        if($request->input('GASES_VENENOSOS')){
            $data->GASES_VENENOSOS = $request->input('GASES_VENENOSOS');
        }
        if($request->input('EMBARAZO_EN_ORINA')){
            $data->EMBARAZO_EN_ORINA = $request->input('EMBARAZO_EN_ORINA');
        }
        if($request->input('ELECTROLITOS')){
            $data->ELECTROLITOS = $request->input('ELECTROLITOS');
        }
        if($request->input('AMILASA')){
            $data->AMILASA = $request->input('AMILASA');
        }
        if($request->input('MAGNESIO')){
            $data->MAGNESIO = $request->input('MAGNESIO');
        }
        if($request->input('GRAM')){
            $data->GRAM = $request->input('GRAM');
        }
        if($request->input('CETONEMIA')){
            $data->CETONEMIA = $request->input('CETONEMIA');
        }
        if($request->input('DIGOXINA')){
            $data->DIGOXINA = $request->input('DIGOXINA');
        }
        if($request->input('T3')){
            $data->T3 = $request->input('T3');
        }
        if($request->input('T4')){
            $data->T4 = $request->input('T4');
        }
        if($request->input('TSH')){
            $data->TSH = $request->input('TSH');
        }
        if($request->input('T3LIBRE')){
            $data->T3LIBRE = $request->input('T3LIBRE');
        }
        if($request->input('T4LIBRE')){
            $data->T4LIBRE = $request->input('T4LIBRE');
        }
        if($request->input('FIBRINOGENO')){
            $data->FIBRINOGENO = $request->input('FIBRINOGENO');
        }
        if($request->input('RELUREA_REATININA_EN_O')){
            $data->RELUREA_REATININA_EN_O = $request->input('RELUREA_REATININA_EN_O');
        }
        if($request->input('REL_ACIDO_URICO_CREATININA')){
            $data->REL_ACIDO_URICO_CREATININA = $request->input('REL_ACIDO_URICO_CREATININA');
        }
        if($request->input('REL_FOSFORO_CREATININA')){
            $data->REL_FOSFORO_CREATININA = $request->input('REL_FOSFORO_CREATININA');
        }
        if($request->input('REL_AMILASA_CREATININA_E')){
            $data->REL_AMILASA_CREATININA_E = $request->input('REL_AMILASA_CREATININA_E');
        }
        if($request->input('UREA_EN_ORINA')){
            $data->UREA_EN_ORINA = $request->input('UREA_EN_ORINA');
        }
        if($request->input('PROTEINAS_EN_ORINA')){
            $data->PROTEINAS_EN_ORINA = $request->input('PROTEINAS_EN_ORINA');
        }
        if($request->input('FOSFORO_EN_ORINA')){
            $data->FOSFORO_EN_ORINA = $request->input('FOSFORO_EN_ORINA');
        }
        if($request->input('AMILASA_EN_ORINA')){
            $data->AMILASA_EN_ORINA = $request->input('AMILASA_EN_ORINA');
        }
        if($request->input('MAGNESIO_EN_ORINA')){
            $data->MAGNESIO_EN_ORINA = $request->input('MAGNESIO_EN_ORINA');
        }
        if($request->input('REL_PROTEINA_CREATININA')){
            $data->REL_PROTEINA_CREATININA = $request->input('REL_PROTEINA_CREATININA');
        }
        if($request->input('FROTIS_DE_SANGRE_PERIFERICO')){
            $data->FROTIS_DE_SANGRE_PERIFERICO = $request->input('FROTIS_DE_SANGRE_PERIFERICO');
        }
        if($request->input('DENGUE_DUO')){
            $data->DENGUE_DUO = $request->input('DENGUE_DUO');
        }
        if($request->input('ESTRADIOL')){
            $data->ESTRADIOL = $request->input('ESTRADIOL');
        }
        if($request->input('FSH')){
            $data->FSH = $request->input('FSH');
        }
        if($request->input('LH')){
            $data->LH = $request->input('LH');
        }
        if($request->input('PSA_LIBRE')){
            $data->PSA_LIBRE = $request->input('PSA_LIBRE');
        }
        if($request->input('ANTIGENO_DE_SUPERFICIE')){
            $data->ANTIGENO_DE_SUPERFICIE = $request->input('ANTIGENO_DE_SUPERFICIE');
        }
        if($request->input('CORE_TOTAL')){
            $data->CORE_TOTAL = $request->input('CORE_TOTAL');
        }
        if($request->input('CORE_M')){
            $data->CORE_M = $request->input('CORE_M');
        }
        if($request->input('TOXO_M')){
            $data->TOXO_M = $request->input('TOXO_M');
        }
        if($request->input('TOXO_G')){
            $data->TOXO_G = $request->input('TOXO_G');
        }
        if($request->input('GLICEMIA_POST_PRANDIAL')){
            $data->GLICEMIA_POST_PRANDIAL = $request->input('GLICEMIA_POST_PRANDIAL');
        }
        if($request->input('INSULINA_BASAL')){
            $data->INSULINA_BASAL = $request->input('INSULINA_BASAL');
        }
        if($request->input('HEMOGLOBINA_GLICOSILADA')){
            $data->HEMOGLOBINA_GLICOSILADA = $request->input('HEMOGLOBINA_GLICOSILADA');
        }
        if($request->input('TROPONINA_T')){
            $data->TROPONINA_T = $request->input('TROPONINA_T');
        }
        if($request->input('GANMAGLUTAMINA_GGT')){
            $data->GANMAGLUTAMINA_GGT = $request->input('GANMAGLUTAMINA_GGT');
        }
        if($request->input('DIMERO_D')){
            $data->DIMERO_D = $request->input('DIMERO_D');
        }
        if($request->input('MICROALBUMINURIA')){
            $data->MICROALBUMINURIA = $request->input('MICROALBUMINURIA');
        }
        if($request->input('PEPTIDO_NATRIURETICO')){
            $data->PEPTIDO_NATRIURETICO = $request->input('PEPTIDO_NATRIURETICO');
        }
        if($request->input('MIOGLOBINA')){
            $data->MIOGLOBINA = $request->input('MIOGLOBINA');
        }
        if($request->input('MONONUCLEOSIS_INFECCIOSA')){
            $data->MONONUCLEOSIS_INFECCIOSA = $request->input('MONONUCLEOSIS_INFECCIOSA');
        }
        if($request->input('HEPATITIS_B_CORE')){
            $data->HEPATITIS_B_CORE = $request->input('HEPATITIS_B_CORE');
        }
        if($request->input('HEPATITIS_B_SUPERFICIE')){
            $data->HEPATITIS_B_SUPERFICIE = $request->input('HEPATITIS_B_SUPERFICIE');
        }
        if($request->input('HEPATITIS_C_VIRUS_HCV')){
            $data->HEPATITIS_C_VIRUS_HCV = $request->input('HEPATITIS_C_VIRUS_HCV');
        }
        if($request->input('HELICOBACTER_PILORI')){
            $data->HELICOBACTER_PILORI = $request->input('HELICOBACTER_PILORI');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Laboratorios']], 500);
        }
    }
    public function updateLaboratorio($id, Request $request){
        
        try
        {
            $data = Laboratorio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Laboratorios'
                ]
            ], 500);
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('nombre');
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'fecha no puede estar vacio']], 422);
        }
        if($request->input('id_paciente')){
            $data->id_paciente = $request->input('nombre');
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_paciente no puede estar vacio']], 422);
        }
        if($request->input('ACIDO_URICO_SERICO')){
            $data->ACIDO_URICO_SERICO = $request->input('ACIDO_URICO_SERICO');
        }
        if($request->input('ASTO')){
            $data->ASTO = $request->input('ASTO');
        }
        if($request->input('BILIRUBINA_TOTAL_FRACCI')){
            $data->BILIRUBINA_TOTAL_FRACCI = $request->input('BILIRUBINA_TOTAL_FRACCI');
        }
        if($request->input('CALCIO_SERICO')){
            $data->CALCIO_SERICO = $request->input('CALCIO_SERICO');
        }
        if($request->input('COLESTEROL')){
            $data->COLESTEROL = $request->input('COLESTEROL');
        }
        if($request->input('CREATININA')){
            $data->CREATININA = $request->input('CREATININA');
        }
        if($request->input('CURVA_DE_TOLERANCIA_GLUC')){
            $data->CURVA_DE_TOLERANCIA_GLUC = $request->input('CURVA_DE_TOLERANCIA_GLUC');
        }
        if($request->input('DEPURACION_DE_CREATININA')){
            $data->DEPURACION_DE_CREATININA = $request->input('DEPURACION_DE_CREATININA');
        }
        if($request->input('EMBARAZO_EN_SANGRE')){
            $data->EMBARAZO_EN_SANGRE = $request->input('EMBARAZO_EN_SANGRE');
        }
        if($request->input('ENZIMA_CARDIACA_CK')){
            $data->ENZIMA_CARDIACA_CK = $request->input('ENZIMA_CARDIACA_CK');
        }
        if($request->input('ENZIMA_CARDIACA_CKMB')){
            $data->ENZIMA_CARDIACA_CKMB = $request->input('ENZIMA_CARDIACA_CKMB');
        }
        if($request->input('ENZIMA_CARDIACA_LDH')){
            $data->ENZIMA_CARDIACA_LDH = $request->input('ENZIMA_CARDIACA_LDH');
        }
        if($request->input('FOSFATASA_ACIDA')){
            $data->FOSFATASA_ACIDA = $request->input('FOSFATASA_ACIDA');
        }
        if($request->input('FOSFATASA_ALCALINA')){
            $data->FOSFATASA_ALCALINA = $request->input('FOSFATASA_ALCALINA');
        }
        if($request->input('FOSFORO')){
            $data->FOSFORO = $request->input('FOSFORO');
        }
        if($request->input('GLICEMIA')){
            $data->GLICEMIA = $request->input('GLICEMIA');
        }
        if($request->input('ACIDO_URICO_EN_ORINA')){
            $data->ACIDO_URICO_EN_ORINA = $request->input('ACIDO_URICO_EN_ORINA');
        }
        if($request->input('GRUPO_SANGUINEO')){
            $data->GRUPO_SANGUINEO = $request->input('GRUPO_SANGUINEO');
        }
        if($request->input('HDL_LDL')){
            $data->HDL_LDL = $request->input('HDL_LDL');
        }
        if($request->input('HECES')){
            $data->HECES = $request->input('HECES');
        }
        if($request->input('HEMATOLOGIA_COMPLETA')){
            $data->HEMATOLOGIA_COMPLETA = $request->input('HEMATOLOGIA_COMPLETA');
        }
        if($request->input('HIERRO')){
            $data->HIERRO = $request->input('HIERRO');
        }
        if($request->input('HIV')){
            $data->HIV = $request->input('HIV');
        }
        if($request->input('ORINA')){
            $data->ORINA = $request->input('ORINA');
        }
        if($request->input('PSA_TOTAL')){
            $data->PSA_TOTAL = $request->input('PSA_TOTAL');
        }
        if($request->input('PTT')){
            $data->PTT = $request->input('PTT');
        }
        if($request->input('PLAQUETAS')){
            $data->PLAQUETAS = $request->input('PLAQUETAS');
        }
        if($request->input('PROTEINA_C_REACTIVA')){
            $data->PROTEINA_C_REACTIVA = $request->input('PROTEINA_C_REACTIVA');
        }
        if($request->input('PROTEINAS_TOTAL_FRACCION')){
            $data->PROTEINAS_TOTAL_FRACCION = $request->input('PROTEINAS_TOTAL_FRACCION');
        }
        if($request->input('RA_TEST')){
            $data->RA_TEST = $request->input('RA_TEST');
        }
        if($request->input('ORINA')){
            $data->ORINA = $request->input('ORINA');
        }
        if($request->input('REL_CALCIO_CREATININA_EN')){
            $data->REL_CALCIO_CREATININA_EN = $request->input('REL_CALCIO_CREATININA_EN');
        }
        if($request->input('RETICULOCITOS')){
            $data->RETICULOCITOS = $request->input('RETICULOCITOS');
        }
        if($request->input('SANGRE_OCULTA_EN_HECES')){
            $data->SANGRE_OCULTA_EN_HECES = $request->input('SANGRE_OCULTA_EN_HECES');
        }
        if($request->input('TIEMPO_DE_PROTOMBINA')){
            $data->TIEMPO_DE_PROTOMBINA = $request->input('TIEMPO_DE_PROTOMBINA');
        }
        if($request->input('TIEMPO_SANGRIA_COAGULACION')){
            $data->TIEMPO_SANGRIA_COAGULACION = $request->input('TIEMPO_SANGRIA_COAGULACION');
        }
        if($request->input('TRANSAMINASA_TGO')){
            $data->TRANSAMINASA_TGO = $request->input('TRANSAMINASA_TGO');
        }
        if($request->input('TRANSAMINASA_TGP')){
            $data->TRANSAMINASA_TGP = $request->input('TRANSAMINASA_TGP');
        }
        if($request->input('TRANSAMINASA_TGOTGP')){
            $data->TRANSAMINASA_TGOTGP = $request->input('TRANSAMINASA_TGOTGP');
        }
        if($request->input('TRIGLICERIDOS')){
            $data->TRIGLICERIDOS = $request->input('TRIGLICERIDOS');
        }
        if($request->input('UREA')){
            $data->UREA = $request->input('UREA');
        }
        if($request->input('VDRL')){
            $data->VDRL = $request->input('VDRL');
        }
        if($request->input('VELOCIDAD_SED_GLOBULAR')){
            $data->VELOCIDAD_SED_GLOBULAR = $request->input('VELOCIDAD_SED_GLOBULAR');
        }
        if($request->input('VLDL')){
            $data->VLDL = $request->input('VLDL');
        }
        if($request->input('CALCIO_EN_ORINA')){
            $data->CALCIO_EN_ORINA = $request->input('CALCIO_EN_ORINA');
        }
        if($request->input('PROTEINURIA_EN_ORINA_24')){
            $data->PROTEINURIA_EN_ORINA_24 = $request->input('PROTEINURIA_EN_ORINA_24');
        }
        if($request->input('TROPONINA')){
            $data->TROPONINA = $request->input('TROPONINA');
        }
        if($request->input('GASES_ARTERIALES')){
            $data->GASES_ARTERIALES = $request->input('GASES_ARTERIALES');
        }
        if($request->input('GASES_VENENOSOS')){
            $data->GASES_VENENOSOS = $request->input('GASES_VENENOSOS');
        }
        if($request->input('EMBARAZO_EN_ORINA')){
            $data->EMBARAZO_EN_ORINA = $request->input('EMBARAZO_EN_ORINA');
        }
        if($request->input('ELECTROLITOS')){
            $data->ELECTROLITOS = $request->input('ELECTROLITOS');
        }
        if($request->input('AMILASA')){
            $data->AMILASA = $request->input('AMILASA');
        }
        if($request->input('MAGNESIO')){
            $data->MAGNESIO = $request->input('MAGNESIO');
        }
        if($request->input('GRAM')){
            $data->GRAM = $request->input('GRAM');
        }
        if($request->input('CETONEMIA')){
            $data->CETONEMIA = $request->input('CETONEMIA');
        }
        if($request->input('DIGOXINA')){
            $data->DIGOXINA = $request->input('DIGOXINA');
        }
        if($request->input('T3')){
            $data->T3 = $request->input('T3');
        }
        if($request->input('T4')){
            $data->T4 = $request->input('T4');
        }
        if($request->input('TSH')){
            $data->TSH = $request->input('TSH');
        }
        if($request->input('T3LIBRE')){
            $data->T3LIBRE = $request->input('T3LIBRE');
        }
        if($request->input('T4LIBRE')){
            $data->T4LIBRE = $request->input('T4LIBRE');
        }
        if($request->input('FIBRINOGENO')){
            $data->FIBRINOGENO = $request->input('FIBRINOGENO');
        }
        if($request->input('RELUREA_REATININA_EN_O')){
            $data->RELUREA_REATININA_EN_O = $request->input('RELUREA_REATININA_EN_O');
        }
        if($request->input('REL_ACIDO_URICO_CREATININA')){
            $data->REL_ACIDO_URICO_CREATININA = $request->input('REL_ACIDO_URICO_CREATININA');
        }
        if($request->input('REL_FOSFORO_CREATININA')){
            $data->REL_FOSFORO_CREATININA = $request->input('REL_FOSFORO_CREATININA');
        }
        if($request->input('REL_AMILASA_CREATININA_E')){
            $data->REL_AMILASA_CREATININA_E = $request->input('REL_AMILASA_CREATININA_E');
        }
        if($request->input('UREA_EN_ORINA')){
            $data->UREA_EN_ORINA = $request->input('UREA_EN_ORINA');
        }
        if($request->input('PROTEINAS_EN_ORINA')){
            $data->PROTEINAS_EN_ORINA = $request->input('PROTEINAS_EN_ORINA');
        }
        if($request->input('FOSFORO_EN_ORINA')){
            $data->FOSFORO_EN_ORINA = $request->input('FOSFORO_EN_ORINA');
        }
        if($request->input('AMILASA_EN_ORINA')){
            $data->AMILASA_EN_ORINA = $request->input('AMILASA_EN_ORINA');
        }
        if($request->input('MAGNESIO_EN_ORINA')){
            $data->MAGNESIO_EN_ORINA = $request->input('MAGNESIO_EN_ORINA');
        }
        if($request->input('REL_PROTEINA_CREATININA')){
            $data->REL_PROTEINA_CREATININA = $request->input('REL_PROTEINA_CREATININA');
        }
        if($request->input('FROTIS_DE_SANGRE_PERIFERICO')){
            $data->FROTIS_DE_SANGRE_PERIFERICO = $request->input('FROTIS_DE_SANGRE_PERIFERICO');
        }
        if($request->input('DENGUE_DUO')){
            $data->DENGUE_DUO = $request->input('DENGUE_DUO');
        }
        if($request->input('ESTRADIOL')){
            $data->ESTRADIOL = $request->input('ESTRADIOL');
        }
        if($request->input('FSH')){
            $data->FSH = $request->input('FSH');
        }
        if($request->input('LH')){
            $data->LH = $request->input('LH');
        }
        if($request->input('PSA_LIBRE')){
            $data->PSA_LIBRE = $request->input('PSA_LIBRE');
        }
        if($request->input('ANTIGENO_DE_SUPERFICIE')){
            $data->ANTIGENO_DE_SUPERFICIE = $request->input('ANTIGENO_DE_SUPERFICIE');
        }
        if($request->input('CORE_TOTAL')){
            $data->CORE_TOTAL = $request->input('CORE_TOTAL');
        }
        if($request->input('CORE_M')){
            $data->CORE_M = $request->input('CORE_M');
        }
        if($request->input('TOXO_M')){
            $data->TOXO_M = $request->input('TOXO_M');
        }
        if($request->input('TOXO_G')){
            $data->TOXO_G = $request->input('TOXO_G');
        }
        if($request->input('GLICEMIA_POST_PRANDIAL')){
            $data->GLICEMIA_POST_PRANDIAL = $request->input('GLICEMIA_POST_PRANDIAL');
        }
        if($request->input('INSULINA_BASAL')){
            $data->INSULINA_BASAL = $request->input('INSULINA_BASAL');
        }
        if($request->input('HEMOGLOBINA_GLICOSILADA')){
            $data->HEMOGLOBINA_GLICOSILADA = $request->input('HEMOGLOBINA_GLICOSILADA');
        }
        if($request->input('TROPONINA_T')){
            $data->TROPONINA_T = $request->input('TROPONINA_T');
        }
        if($request->input('GANMAGLUTAMINA_GGT')){
            $data->GANMAGLUTAMINA_GGT = $request->input('GANMAGLUTAMINA_GGT');
        }
        if($request->input('DIMERO_D')){
            $data->DIMERO_D = $request->input('DIMERO_D');
        }
        if($request->input('MICROALBUMINURIA')){
            $data->MICROALBUMINURIA = $request->input('MICROALBUMINURIA');
        }
        if($request->input('PEPTIDO_NATRIURETICO')){
            $data->PEPTIDO_NATRIURETICO = $request->input('PEPTIDO_NATRIURETICO');
        }
        if($request->input('MIOGLOBINA')){
            $data->MIOGLOBINA = $request->input('MIOGLOBINA');
        }
        if($request->input('MONONUCLEOSIS_INFECCIOSA')){
            $data->MONONUCLEOSIS_INFECCIOSA = $request->input('MONONUCLEOSIS_INFECCIOSA');
        }
        if($request->input('HEPATITIS_B_CORE')){
            $data->HEPATITIS_B_CORE = $request->input('HEPATITIS_B_CORE');
        }
        if($request->input('HEPATITIS_B_SUPERFICIE')){
            $data->HEPATITIS_B_SUPERFICIE = $request->input('HEPATITIS_B_SUPERFICIE');
        }
        if($request->input('HEPATITIS_C_VIRUS_HCV')){
            $data->HEPATITIS_C_VIRUS_HCV = $request->input('HEPATITIS_C_VIRUS_HCV');
        }
        if($request->input('HELICOBACTER_PILORI')){
            $data->HELICOBACTER_PILORI = $request->input('HELICOBACTER_PILORI');
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Laboratorios']], 500);
        }
    }
    public function destroyLaboratorio($id){
        try
        {
            $data = Laboratorio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Laboratorio']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Laboratorio']], 500);
        }
    }
}
