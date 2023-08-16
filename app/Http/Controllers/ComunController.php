<?php
namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Permiso;
use App\Models\Localidad;
use App\Models\Perfil;
use App\Models\Estatus;
use App\Models\Tipoestatus;
use App\Models\Sistema;
use App\Models\Alimento;
use App\Models\Categoria;
use App\Models\Profesion;
use App\Models\Estadocivil;
use App\Models\Contacto;
use App\Models\Opinion;
use App\Models\Menu;
use App\Models\User;
class ComunController extends BaseController
{
    private $token;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        try
        {
            $configuracion = Configuracion::where('variable', 'token')->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Configuracion'
                ]
            ], 500);
        }
        if(!empty($configuracion)){
            $this->token=$configuracion->valor;
        }
    }
    public function indexUsuario(){
        try
        {
            $usuarios = User::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Usuarios'
                ]
            ], 500);
        }

        if($usuarios)
        {
            $data = [];
            foreach($usuarios as $usuario)
            {
                $types = [];
                $types = [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'login' => $usuario->login,
                    'email' => $usuario->email,
                    'telefono' => $usuario->telefono,
                    'estatus' => $usuario->estatus,
                    'email_verified' => $usuario->email_verified,
                    'telefono_verified' => $usuario->telefono_verified
                ];
                $data[] = $types;
            }
        }
        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Usuarios was not found'
                ]
            ], 404);
        }
    }
    public function showUsuario($id){
        try
        {
            $user = User::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Usuarios'
                ]
            ], 500);
        }
        if($user)
        {
            $data = [];
            $data = [
                'nombre' => $user->nombre,
                'login' => $user->login,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'estatus' => $user->estatus,
                'email_verified' => $user->email_verified,
                'telefono_verified' => $user->telefono_verified
            ];
        }
        if(!empty($data))
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Usuario was not found'
                ]
            ], 404);
        }
    }
    public function storeUsuario(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new User();
        if($request->input('nombre')){ 
            $data->nombre = $request->input('nombre');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre'
                ]
            ], 422);
        }
        if($request->input('login')){ 
            $data->login= $request->input('login');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'login'
                ]
            ], 422);
        }
        if($request->input('clave')){ 
            $data->clave= Hash::make($request->input('clave'));
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'password'
                ]
            ], 422);
        }
        if($request->input('email')){ 
            $data->email = $request->input('email');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email es Requerido'
                ]
            ], 422);
        }
        if($request->input('telefono')){ 
            $data->telefono = $request->input('telefono');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Telefono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('estatus')){ 
            $data->estatus = $request->input('estatus');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'estatus es Requerido no puede estar vacio'
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
                    'errorMessage' => 'Error storing Usuarios'
                ]
            ], 500);
        }
    }
    public function updateUsuario($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = User::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Usuarios'
                ]
            ], 500);
        }
        if($request->input('nombre')){ 
            $data->nombre = $request->input('nombre');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre'
                ]
            ], 422);
        }
        if($request->input('login')){ 
            $data->login= $request->input('login');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'login'
                ]
            ], 422);
        }
        if($request->input('email')){ 
            $data->email = $request->input('email');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email es Requerido'
                ]
            ], 422);
        }
        if($request->input('telefono')){ 
            $data->telefono = $request->input('telefono');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Telefono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('estatus')){ 
            $data->estatus = $request->input('estatus');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'estatus es Requerido no puede estar vacio'
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
                    'errorMessage' => 'Error updating Usuarios'
                ]
            ], 500);
        }
    }
    public function destroyUsuario($id){
        try
        {
            $data = User::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Usuario'
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
                    'errorMessage' => 'Error deleting Usuario'
                ]
            ], 500);
        }
    }
    public function indexEstado(){
        try
        {
            $estados = Estado::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estados'
                ]
            ], 500);
        }

        if($estados)
        {
            $data = [];
            foreach($estados as $estado)
            {
                $types = [];
                $types = [
                    'id'            => $estado->id,
                    'nombre'          => $estado->nombre
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Estados was not found'
                ]
            ], 404);
        }
    }
    public function showEstado($id){
        try
        {
            $estado = Estado::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estados'
                ]
            ], 500);
        }
        if($estado)
        {
            $data = [];
            $data = [
                'id' => $estado->id,
                'nombre' => $estado->nombre
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Estado was not found'
                ]
            ], 404);
        }
    }
    public function storeEstado(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Estado();
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
                    'errorMessage' => 'Error storing Estados'
                ]
            ], 500);
        }
    }
    public function updateEstado($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Estado::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estados'
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
                    'errorMessage' => 'Error updating Estados'
                ]
            ], 500);
        }
    }
    public function destroyEstado($id){
        try
        {
            $data = Estado::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estado'
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
                    'errorMessage' => 'Error deleting Estado'
                ]
            ], 500);
        }
    }
    public function indexMunicipio(){
        try
        {
            $municipios = Municipio::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Municipios'
                ]
            ], 500);
        }

        if($municipios)
        {
            $data = [];
            foreach($municipios as $municipio)
            {
                $types = [];
                $types = [
                    'id' => $municipio->id,
                    'nombre' => $municipio->nombre,
                    'id_estado' => $municipio->id_estado
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Municipios was not found'
                ]
            ], 404);
        }
    }
    public function showMunicipio($id){
        try
        {
            $municipio = Municipio::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Municipios'
                ]
            ], 500);
        }
        if($municipio)
        {
            $data = [];
            $data = [
                'id' => $municipio->id,
                'nombre' => $municipio->nombre,
                'id_estado' => $municipio->id_estado
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Municipio was not found'
                ]
            ], 404);
        }
    }
    public function storeMunicipio(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Municipio();
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
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
                    'errorMessage' => 'Error storing Municipios'
                ]
            ], 500);
        }
    }
    public function updateMunicipio($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Municipio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Municipios'
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
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
                    'errorMessage' => 'Error updating Municipios'
                ]
            ], 500);
        }
    }
    public function destroyMunicipio($id){
        try
        {
            $data = Municipio::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Municipio'
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
                    'errorMessage' => 'Error deleting Municipio'
                ]
            ], 500);
        }
    }
    public function indexParroquia(){
        try
        {
            $parroquias = Parroquia::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Parroquias'
                ]
            ], 500);
        }

        if($parroquias)
        {
            $data = [];
            foreach($parroquias as $parroquia)
            {
                $types = [];
                $types = [
                    'id' => $parroquia->id,
                    'nombre' => $parroquia->nombre,
                    'id_estado' => $parroquia->id_estado,
                    'id_municipio' => $parroquia->id_municipio
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Parroquias was not found'
                ]
            ], 404);
        }
    }
    public function showParroquia($id){
        try
        {
            $parroquia = Parroquia::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Parroquias'
                ]
            ], 500);
        }
        if($parroquia)
        {
            $data = [];
            $data = [
                'id' => $parroquia->id,
                'nombre' => $parroquia->nombre,
                'id_estado' => $parroquia->id_estado,
                'id_municipio' => $parroquia->id_municipio
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Parroquia was not found'
                ]
            ], 404);
        }
    }
    public function storeParroquia(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Parroquia();
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){
            $data->id_municipio = $request->input('id_municipio');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el municipio'
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
                    'errorMessage' => 'Error storing Parroquias'
                ]
            ], 500);
        }
    }
    public function updateParroquia($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Parroquia::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Parroquias'
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){
            $data->id_municipio = $request->input('id_municipio');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el municipio'
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
                    'errorMessage' => 'Error updating Parroquias'
                ]
            ], 500);
        }
    }
    public function destroyParroquia($id){
        try
        {
            $data = Parroquia::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Parroquia'
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
                    'errorMessage' => 'Error deleting Parroquia'
                ]
            ], 500);
        }
    }
    public function indexLocalidad(){
        try
        {
            $localidades = Localidad::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Localidads'
                ]
            ], 500);
        }

        if($localidades)
        {
            $data = [];
            foreach($localidades as $localidad)
            {
                $types = [];
                $types = [
                    'id'            => $localidad->id,
                    'nombre'          => $localidad->nombre,
                    'id_estado' => $localidad->id_estado,
                    'id_municipio' => $localidad->id_municipio,
                    'id_parroquia' => $localidad->id_parroquia
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Localidads was not found'
                ]
            ], 404);
        }
    }
    public function showLocalidad($id){
        try
        {
            $localidad = Localidad::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Localidads'
                ]
            ], 500);
        }
        if($localidad)
        {
            $data = [];
            $data = [
                'id' => $localidad->id,
                'nombre' => $localidad->nombre,
                'id_estado' => $localidad->id_estado,
                'id_municipio' => $localidad->id_municipio,
                'id_parroquia' => $localidad->id_parroquia
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Localidad was not found'
                ]
            ], 404);
        }
    }
    public function storeLocalidad(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Localidad();
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){
            $data->id_municipio = $request->input('id_municipio');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el municipio'
                ]
            ], 422);
        }
        if($request->input('id_parroquia')){
            $data->id_parroquia = $request->input('id_parroquia');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '004',
                    'error' => 'Debe seleccionar el parroquia'
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
                    'errorMessage' => 'Error storing Localidads'
                ]
            ], 500);
        }
    }
    public function updateLocalidad($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Localidad::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Localidads'
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
        if($request->input('id_estado')){
            $data->id_estado = $request->input('id_estado');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el estado'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){
            $data->id_municipio = $request->input('id_municipio');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el municipio'
                ]
            ], 422);
        }
        if($request->input('id_parroquia')){
            $data->id_parroquia = $request->input('id_parroquia');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '004',
                    'error' => 'Debe seleccionar el parroquia'
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
                    'errorMessage' => 'Error updating Localidads'
                ]
            ], 500);
        }
    }
    public function destroyLocalidad($id){
        try
        {
            $data = Localidad::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Localidad'
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
                    'errorMessage' => 'Error deleting Localidad'
                ]
            ], 500);
        }
    }
    public function indexSistema(){
        try
        {
            $sistemas = Sistema::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Sistemas'
                ]
            ], 500);
        }
        if($sistemas)
        {
            $data = [];
            foreach($sistemas as $sistema)
            {
                $types = [];
                $types = [
                    'id'            => $sistema->id,
                    'nombre'          => $sistema->nombre
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200, 'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Sistemas was not found'
                ]
            ], 404);
        }
    }
    public function showSistema($id){
        try
        {
            $sistema = Sistema::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Sistemas'
                ]
            ], 500);
        }
        if($sistema)
        {
            $data = [];
            $data = [
                'id' => $Sistema->id,
                'nombre' => $Sistema->nombre
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
                    'errorMessage' => 'Sistema was not found'
                ]
            ], 404);
        }
    }
    public function storeSistema(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Sistema();
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
                    'errorMessage' => 'Error storing Sistemas'
                ]
            ], 500);
        }
    }
    public function updateSistema($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Sistema::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Sistemas'
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
                    'errorMessage' => 'Error updating Sistemas'
                ]
            ], 500);
        }
    }
    public function destroySistema($id){
        try
        {
            $data = Sistema::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Sistema'
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
                    'errorMessage' => 'Error deleting Sistema'
                ]
            ], 500);
        }
    }
    public function indexEstatus(){
        try
        {
            $estatuss = Estatus::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estatuss'
                ]
            ], 500);
        }
        if($estatuss)
        {
            $data = [];
            foreach($estatuss as $estatus)
            {
                $types = [];
                $types = [
                    'id'            => $estatus->id,
                    'nombre'          => $estatus->nombre,
                    'tipo_estatus' => $estatus->tipo_estatus
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
                    'errorMessage' => 'Estatuss was not found'
                ]
            ], 404);
        }
    }
    public function showEstatus($id){
        try
        {
            $estatus = Estatus::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estatus'
                ]
            ], 500);
        }
        if($estatus)
        {
            $data = [];
            $data = [
                'id' => $estatus->id,
                'nombre' => $estatus->nombre,
                'tipo_estatus' => $estatus->tipo_estatus
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK', 'data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Estatus was not found'
                ]
            ], 404);
        }
    }
    public function storeEstatus(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Estatus();
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
        if($request->input('tipo_estatus')){
            $data->id_tipoestatus = $request->input('tipo_estatus');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Seleccione el tipo de estatus'
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
                    'errorMessage' => 'Error storing Estatuss'
                ]
            ], 500);
        }
    }
    public function updateEstatus($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Estatus::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estatuss'
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
        if($request->input('tipo_estatus')){
            $data->id_tipoestatus = $request->input('tipo_estatus');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Seleccione el tipo de estatus'
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
                    'errorMessage' => 'Error updating Estatuss'
                ]
            ], 500);
        }
    }
    public function destroyEstatus($id){
        try
        {
            $data = Estatus::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estatus'
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
                    'errorMessage' => 'Error deleting Estatus'
                ]
            ], 500);
        }
    }
    public function indexPerfil(){
        try
        {
            $perfiles = Perfil::select(
             'perfil.id as id_perfil',
             'perfil.id_usuario as id_usuario',
             'perfil.direccion as direccion',
             'perfil.id_estado as id_estado',
             'perfil.id_municipio as id_municipio',
             'perfil.id_parroquia as id_parroquia',
             'perfil.id_localidad as id_localidad',
             'perfil.twitter as twitter',
             'perfil.instagram as instagram',
             'perfil.facebook as facebook',
             'perfil.cedula as cedula',
             'perfil.id_tipousuario as id_tipousuario',
             'users.nombre as nombre',
             'users.login as login',
             'users.email as email',
             'users.telefono as telefono',
             'estado.nombre as estado',
             'municipio.nombre as municipio',
             'parroquia.nombre as parroquia',
             'localidad.nombre as localidad'  
            )->join('comun.users', 'users.id', '=', 'perfil.id_usuario')->join('comun.estado', 'estado.id', '=', 'perfil.id_estado')->join('comun.municipio', 'municipio.id', '=', 'perfil.id_municipio')->join('comun.parroquia', 'parroquia.id', '=', 'perfil.id_parroquia')->join('comun.localidad', 'localidad.id', '=', 'perfil.id_localidad')->get();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Perfils'
                ]
            ], 500);
        }
        if($perfiles)
        {
            $data = [];
            foreach($perfiles as $perfil)
            {
                $types = [];
                $types = [
                    'id'  => $perfil->id_perfil,
                    'id_usuario'  => $perfil->id_usuario,
                    'direccion'  => $perfil->direccion,
                    'id_estado'  => $perfil->id_estado,
                    'id_municipio'  => $perfil->id_municipio,
                    'id_parroquia'  => $perfil->id_parroquia,
                    'id_localidad'  => $perfil->id_localidad,
                    'twitter'  => $perfil->twitter,
                    'instagram'  => $perfil->instagram,
                    'facebook'  => $perfil->facebook,
                    'cedula'  => $perfil->cedula,
                    'id_tipousuario'  => $perfil->id_tipousuario,
                    'nombre'  => $perfil->nombre,
                    'login'  => $perfil->login,
                    'email'  => $perfil->email,
                    'telefono' => $perfil->telefono,
                    'estado'  => $perfil->estado,
                    'municipio'  => $perfil->municipio,
                    'parroquia'  => $perfil->parroquia,
                    'localidad'  => $perfil->localidad
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
                    'errorMessage' => 'Perfils was not found'
                ]
            ], 404);
        }
    }
    public function showPerfil($id){

        try
        {
            $perfiles = Perfil::select(
             'perfil.id as id_perfil',
             'perfil.id_usuario as id_usuario',
             'perfil.direccion as direccion',
             'perfil.id_estado as id_estado',
             'perfil.id_municipio as id_municipio',
             'perfil.id_parroquia as id_parroquia',
             'perfil.id_localidad as id_localidad',
             'perfil.twitter as twitter',
             'perfil.instagram as instagram',
             'perfil.facebook as facebook',
             'perfil.cedula as cedula',
             'perfil.id_tipousuario as id_tipousuario',
             'users.nombre as nombre',
             'users.login as login',
             'users.email as email',
             'users.telefono as telefono',
             'estado.nombre as estado',
             'municipio.nombre as municipio',
             'parroquia.nombre as parroquia',
             'localidad.nombre as localidad'  
            )->join('comun.users', 'users.id', '=', 'perfil.id_usuario')->join('comun.estado', 'estado.id', '=', 'perfil.id_estado')->join('comun.municipio', 'municipio.id', '=', 'perfil.id_municipio')->join('comun.parroquia', 'parroquia.id', '=', 'perfil.id_parroquia')->join('comun.localidad', 'localidad.id', '=', 'perfil.id_localidad')->where('perfil.id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Perfils'
                ]
            ], 500);
        }
        if(!empty($perfiles))
        {
            $data = [];
            $data = [
                'id' => $perfiles->id_perfil,
                'id_usuario'  => $perfiles->id_usuario,
                'direccion'  => $perfiles->direccion,
                'id_estado'  => $perfiles->id_estado,
                'id_municipio'  => $perfiles->id_municipio,
                'id_parroquia'  => $perfiles->id_parroquia,
                'id_localidad'  => $perfiles->id_localidad,
                'twitter'  => $perfiles->twitter,
                'instagram'  => $perfiles->instagram,
                'facebook'  => $perfiles->facebook,
                'cedula'  => $perfiles->cedula,
                'id_tipousuario'  => $perfiles->id_tipousuario,
                'nombre'  => $perfiles->nombre,
                'login'  => $perfiles->login,
                'email'  => $perfiles->email,
                'telefono' => $perfiles->telefono,
                'estado'  => $perfiles->estado,
                'municipio'  => $perfiles->municipio,
                'parroquia'  => $perfiles->parroquia,
                'localidad'  => $perfiles->localidad,
            ];
        }
        if(!empty($data))
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Perfil was not found'
                ]
            ], 404);
        }
    }
    public function storePerfil(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Perfil();
        if($request->input('id_usuario')){ 
            $data->id_usuario = $request->input('id_usuario');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Id usuario'
                ]
            ], 422);
        }
        if($request->input('direccion')){ 
            $data->direccion = $request->input('direccion');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Direccion es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_estado')){ 
            $data->id_estado = $request->input('id_estado');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Estado es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){ 
            $data->id_municipio = $request->input('id_municipio');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_parroquia')){ 
            $data->id_parroquia = $request->input('id_parroquia');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Parroquia es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_localidad')){ 
            $data->id_localidad = $request->input('id_localidad');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Localidad es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('twitter')){ 
            $data->twitter = $request->input('twitter');
        }
        if($request->input('instagram')){ 
            $data->instagram = $request->input('instagram');
        }
        if($request->input('facebook')){ 
            $data->facebook = $request->input('facebook');
        }
        if($request->input('cedula')){ 
            $data->cedula = $request->input('cedula');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Cedula es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('tipo_usuario')){ 
            $data->id_tipousuario = $request->input('tipo_usuario');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Tipo de Usuario es Requerido no puede estar vacio'
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
                    'errorMessage' => 'Error storing Perfils'
                ]
            ], 500);
        }
    }
    public function updatePerfil($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Perfil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Perfils'
                ]
            ], 500);
        }
        if($request->input('direccion')){ 
            $data->direccion = $request->input('direccion');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Direccion es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_estado')){ 
            $data->id_estado = $request->input('id_estado');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Estado es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_municipio')){ 
            $data->id_municipio = $request->input('id_municipio');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Nombre no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_parroquia')){ 
            $data->id_parroquia = $request->input('id_parroquia');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Parroquia es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_localidad')){ 
            $data->id_localidad = $request->input('id_localidad');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Localidad es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('twitter')){ 
            $data->twitter = $request->input('twitter');
        }
        if($request->input('instagram')){ 
            $data->instagram = $request->input('instagram');
        }
        if($request->input('facebook')){ 
            $data->facebook = $request->input('facebook');
        }
        if($request->input('cedula')){ 
            $data->cedula = $request->input('cedula');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Cedula es Requerido no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('tipo_usuario')){ 
            $data->id_tipousuario = $request->input('tipo_usuario');
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Tipo de Usuario es Requerido no puede estar vacio'
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
                    'errorMessage' => 'Error updating Perfils'
                ]
            ], 500);
        }
    }
    public function destroyPerfil($id){
        try
        {
            $data = Perfil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Perfil'
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
                    'errorMessage' => 'Error deleting Perfil'
                ]
            ], 500);
        }
    }
    public function indexTipoEstatus(){
        try
        {
            $tipoestatuss = Tipoestatus::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipo Estatus'
                ]
            ], 500);
        }

        if($tipoestatuss)
        {
            $data = [];
            foreach($tipoestatuss as $tipoestatus)
            {
                $types = [];
                $types = [
                    'id'            => $tipoestatus->id,
                    'nombre'          => $tipoestatus->nombre
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Tipo Estatus was not found'
                ]
            ], 404);
        }
    }
    public function showTipoEstatus($id){
        try
        {
            $tipoestatus = Tipoestatus::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipo Estatus'
                ]
            ], 500);
        }
        if($tipoestatus)
        {
            $data = [];
            $data = [
                'id' => $tipoestatus->id,
                'nombre' => $tipoestatus->nombre,
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Tipo Estatus was not found'
                ]
            ], 404);
        }
    }
    public function storeTipoEstatus(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new TipoEstatus();

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
                    'errorMessage' => 'Error storing Tipo Estatuss'
                ]
            ], 500);
        }
    }
    public function updateTipoEstatus($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Tipoestatus::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipo Estatus'
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
                    'errorMessage' => 'Error updating Tipo Estatus'
                ]
            ], 500);
        }
    }
    public function destroyTipoEstatus($id){
        try
        {
            $data = Tipoestatus::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipo Estatus'
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
                    'errorMessage' => 'Error deleting TipoEstatus'
                ]
            ], 500);
        }
    }
    public function indexMenu(){
        try
        {
            $menus = Menu::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Menu'
                ]
            ], 500);
        }

        if($menus)
        {
            $data = [];
            foreach($menus as $menu)
            {
                $types = [];
                $types = [
                    'id'            => $menu->id,
                    'nombre'          => $menu->nombre,
                    'icono'          => $menu->icono,
                    'id_sistema'          => $menu->id_sistema
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Menu was not found'
                ]
            ], 404);
        }
    }
    public function showMenu($id){
        try
        {
            $menu = Menu::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Menu'
                ]
            ], 500);
        }
        if($menu)
        {
            $data = [];
            $data = [
                'id' => $menu->id,
                'nombre' => $menu->nombre,
                'icono' => $menu->icono,
                'id_sistema' => $menu->id_sistema
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Menu was not found'
                ]
            ], 404);
        }
    }
    public function storeMenu(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Menu();
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
        if($request->input('icono')){
            $data->icono = $request->input('icono');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Icono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_sistema')){
            $data->id_sistema = $request->input('id_sistema');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el sistema'
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
                    'errorMessage' => 'Error storing Menus'
                ]
            ], 500);
        }
    }
    public function updateMenu($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Menu::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Menu'
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
        if($request->input('icono')){
            $data->icono = $request->input('icono');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Icono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_sistema')){
            $data->id_sistema = $request->input('id_sistema');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el sistema'
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
                    'errorMessage' => 'Error updating Menu'
                ]
            ], 500);
        }
    }
    public function destroyMenu($id){
        try
        {
            $data = Menu::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Menu'
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
                    'errorMessage' => 'Error deleting Menu'
                ]
            ], 500);
        }
    }
    public function indexPermisos(){
        try
        {
            $permisoss = Permiso::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Permisos'
                ]
            ], 500);
        }

        if($permisoss)
        {
            $data = [];
            foreach($permisoss as $permisos)
            {
                $types = [];
                $types = [
                    'id' => $permisos->id,
                    'id_menu' => $permisos->id_menu,
                    'id_usuario' => $permisos->id_usuario,
                    'id_sistema' => $permisos->id_sistema
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Permisos was not found'
                ]
            ], 404);
        }
    }
    public function showPermisos($id){
        try
        {
            $permisos = Permiso::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Permisos'
                ]
            ], 500);
        }
        if($permisos)
        {
            $data = [];
            $data = [
                'id' => $permisos->id,
                'id_menu' => $permisos->id_menu,
                'id_usuario' => $permisos->id_usuario,
                'id_sistema' => $permisos->id_sistema
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Permisos was not found'
                ]
            ], 404);
        }
    }
    public function storePermisos(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Permiso();
        if($request->input('id_menu')){
            $data->id_menu = $request->input('id_menu');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Debe seleccionar el menu'
                ]
            ], 422);
        }
        if($request->input('id_usuario')){
            $data->id_usuario = $request->input('id_usuario');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el usuario'
                ]
            ], 422);
        }
        if($request->input('id_sistema')){
            $data->id_sistema = $request->input('id_sistema');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el sistema'
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
                    'errorMessage' => 'Error storing Permisoss'
                ]
            ], 500);
        }
    }
    public function updatePermisos($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Permiso::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Permisos'
                ]
            ], 500);
        }

        if($request->input('id_menu')){
            $data->id_menu = $request->input('id_menu');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Debe seleccionar el menu'
                ]
            ], 422);
        }
        if($request->input('id_usuario')){
            $data->id_usuario = $request->input('id_usuario');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '002',
                    'error' => 'Debe seleccionar el usuario'
                ]
            ], 422);
        }
        if($request->input('id_sistema')){
            $data->id_sistema = $request->input('id_sistema');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '003',
                    'error' => 'Debe seleccionar el sistema'
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
                    'errorMessage' => 'Error updating Permisos'
                ]
            ], 500);
        }
    }
    public function destroyPermisos($id){
        try
        {
            $data = Permiso::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Permisos'
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
                    'errorMessage' => 'Error deleting Permisos'
                ]
            ], 500);
        }
    }
    public function indexAlimento(){
        try
        {
            $Alimentos = Alimento::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Alimentos']], 500);
        }
        if($Alimentos)
        {
            $data = [];
            foreach($Alimentos as $Alimento)
            {
                $types = [];
                $types = [
                    'id' => $Alimento->id,
                    'nombre' => $Alimento->nombre
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Alimentos was not found']], 404);
        }
    }
    public function showAlimento($id){
        try
        {
            $Alimento = Alimento::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Alimentos']], 500);
        }
        if($Alimento)
        {
            $data = [];
            $data = [
                'id' => $Alimento->id,
                'nombre' => $Alimento->nombre
            ];
            return response()->json(['responseCode' => 200,'response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json(['responseCode' => 404,'response' => 'Not Found','data' => ['errorCode' => 'Error-2','errorMessage' => 'Alimento was not found']], 404);
        }
    }
    public function storeAlimento(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Alimento();
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
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Alimentos']], 500);
        }
    }
    public function updateAlimento($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Alimento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Alimentos'
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
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error updating Alimentos']], 500);
        }
    }
    public function destroyAlimento($id){
        try
        {
            $data = Alimento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Alimento']], 500);
        }
        try 
        {
            $data->delete();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error deleting Alimento']], 500);
        }
    }
    public function indexCategoria(){
        try
        {
            $Categorias = Categoria::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Categorias'
                ]
            ], 500);
        }
        if($Categorias)
        {
            $data = [];
            foreach($Categorias as $Categoria)
            {
                $types = [];
                $types = [
                    'id' => $Categoria->id,
                    'parent' => $Categoria->parent,
                    'nombre' => $Categoria->nombre
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
                    'errorMessage' => 'Categorias was not found'
                ]
            ], 404);
        }
    }
    public function showCategoria($id){
        try
        {
            $Categoria = Categoria::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Categorias'
                ]
            ], 500);
        }
        if($Categoria)
        {
            $data = [];
            $data = [
                'id' => $Categoria->id,
                'parent' => $Categoria->parent,
                'nombre' => $Categoria->nombre
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
                    'errorMessage' => 'Categoria was not found'
                ]
            ], 404);
        }
    }
    public function storeCategoria(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Categoria();
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
        if($request->input('parent')){
            if(is_int($request->input('parent'))){
                $data->parent=$request->input('parent');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'parent debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'parent no puede estar vacio']],422);
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
                    'errorMessage' => 'Error storing Categorias'
                ]
            ], 500);
        }
    }
    public function updateCategoria($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Categoria::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Categorias'
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
        if($request->input('parent')){
            if(is_int($request->input('parent'))){
                $data->parent=$request->input('parent');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'parent debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'parent no puede estar vacio']],422);
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
                    'errorMessage' => 'Error updating Categorias'
                ]
            ], 500);
        }
    }
    public function destroyCategoria($id){
        try
        {
            $data = Categoria::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Categoria'
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
                    'errorMessage' => 'Error deleting Categoria'
                ]
            ], 500);
        }
    }
    public function indexProfesion(){
        try
        {
            $Profesions = Profesion::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Profesions'
                ]
            ], 500);
        }
        if($Profesions)
        {
            $data = [];
            foreach($Profesions as $Profesion)
            {
                $types = [];
                $types = [
                    'id' => $Profesion->id,
                    'nombre' => $Profesion->nombre
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
                    'errorMessage' => 'Profesions was not found'
                ]
            ], 404);
        }
    }
    public function showProfesion($id){
        try
        {
            $Profesion = Profesion::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Profesions'
                ]
            ], 500);
        }
        if($Profesion)
        {
            $data = [];
            $data = [
                'id' => $Profesion->id,
                'nombre' => $Profesion->nombre
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
                    'errorMessage' => 'Profesion was not found'
                ]
            ], 404);
        }
    }
    public function storeProfesion(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Profesion();
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
                    'errorMessage' => 'Error storing Profesions'
                ]
            ], 500);
        }
    }
    public function updateProfesion($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Profesion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Profesions'
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
                    'errorMessage' => 'Error updating Profesions'
                ]
            ], 500);
        }
    }
    public function destroyProfesion($id){
        try
        {
            $data = Profesion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Profesion'
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
                    'errorMessage' => 'Error deleting Profesion'
                ]
            ], 500);
        }
    }
    public function indexEstadocivil(){
        try
        {
            $Estadocivils = Estadocivil::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estadocivils'
                ]
            ], 500);
        }
        if($Estadocivils)
        {
            $data = [];
            foreach($Estadocivils as $Estadocivil)
            {
                $types = [];
                $types = [
                    'id' => $Estadocivil->id,
                    'nombre' => $Estadocivil->nombre
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
                    'errorMessage' => 'Estadocivils was not found'
                ]
            ], 404);
        }
    }
    public function showEstadocivil($id){
        try
        {
            $Estadocivil = Estadocivil::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estadocivils'
                ]
            ], 500);
        }
        if($Estadocivil)
        {
            $data = [];
            $data = [
                'id' => $Estadocivil->id,
                'nombre' => $Estadocivil->nombre
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
                    'errorMessage' => 'Estadocivil was not found'
                ]
            ], 404);
        }
    }
    public function storeEstadocivil(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Estadocivil();
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
                    'errorMessage' => 'Error storing Estadocivils'
                ]
            ], 500);
        }
    }
    public function updateEstadocivil($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Estadocivil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estadocivils'
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
                    'errorMessage' => 'Error updating Estadocivils'
                ]
            ], 500);
        }
    }
    public function destroyEstadocivil($id){
        try
        {
            $data = Estadocivil::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Estadocivil'
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
                    'errorMessage' => 'Error deleting Estadocivil'
                ]
            ], 500);
        }
    }
    public function indexContacto(){
        try
        {
            $Contactos = Contacto::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Contactos'
                ]
            ], 500);
        }

        if($Contactos)
        {
            $data = [];
            foreach($Contactos as $Contacto)
            {
                $types = [];
                $types = [
                    'id' => $Contacto->id,
                    'nombre' => $Contacto->nombre,
                    'email' => $Contacto->email,
                    'telefono' => $Contacto->telefono,
                    'mensaje' => $Contacto->mensaje
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Contactos was not found'
                ]
            ], 404);
        }
    }
    public function showContacto($id){
        try
        {
            $Contacto = Contacto::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Contactos'
                ]
            ], 500);
        }
        if($Contacto)
        {
            $data = [];
            $data = [
                'id' => $Contacto->id,
                'nombre' => $Contacto->nombre,
                'email' => $Contacto->email,
                'telefono' => $Contacto->telefono,
                'mensaje' => $Contacto->mensaje
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Contacto was not found'
                ]
            ], 404);
        }
    }
    public function storeContacto(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Contacto();
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
        if($request->input('email')){
            $data->email = $request->input('email');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('telefono')){
            $data->telefono = $request->input('telefono');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'telefono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('mensaje')){
            $data->mensaje = $request->input('mensaje');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'mensaje no puede estar vacio'
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
                    'errorMessage' => 'Error storing Contactos'
                ]
            ], 500);
        }
    }
    public function updateContacto($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Contacto::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Contactos'
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
        if($request->input('email')){
            $data->email = $request->input('email');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('telefono')){
            $data->telefono = $request->input('telefono');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'telefono no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('mensaje')){
            $data->mensaje = $request->input('mensaje');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'mensaje no puede estar vacio'
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
                    'errorMessage' => 'Error updating Contactos'
                ]
            ], 500);
        }
    }
    public function destroyContacto($id){
        try
        {
            $data = Contacto::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Contacto'
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
                    'errorMessage' => 'Error deleting Contacto'
                ]
            ], 500);
        }
    }
    public function indexOpinion(){
        try
        {
            $Opinions = Opinion::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Opinions'
                ]
            ], 500);
        }

        if($Opinions)
        {
            $data = [];
            foreach($Opinions as $Opinion)
            {
                $types = [];
                $types = [
                    'id' => $Opinion->id,
                    'nombre' => $Opinion->nombre,
                    'email' => $Opinion->email,
                    'id_post' => $Opinion->id_post,
                    'mensaje' => $Opinion->mensaje
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Opinions was not found'
                ]
            ], 404);
        }
    }
    public function showOpinion($id){
        try
        {
            $Opinion = Opinion::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Opinions'
                ]
            ], 500);
        }
        if($Opinion)
        {
            $data = [];
            $data = [
                'id' => $Opinion->id,
                'nombre' => $Opinion->nombre,
                'email' => $Opinion->email,
                'id_post' => $Opinion->id_post,
                'mensaje' => $Opinion->mensaje
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Opinion was not found'
                ]
            ], 404);
        }
    }
    public function storeOpinion(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Opinion();
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
        if($request->input('email')){
            $data->email = $request->input('email');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_post')){
            $data->id_post = $request->input('id_post');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'id_post no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('mensaje')){
            $data->mensaje = $request->input('mensaje');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'mensaje no puede estar vacio'
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
                    'errorMessage' => 'Error storing Opinions'
                ]
            ], 500);
        }
    }
    public function updateOpinion($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Opinion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Opinions'
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
        if($request->input('email')){
            $data->email = $request->input('email');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Email no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('id_post')){
            $data->id_post = $request->input('id_post');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'id_post no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('mensaje')){
            $data->mensaje = $request->input('mensaje');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'mensaje no puede estar vacio'
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
                    'errorMessage' => 'Error updating Opinions'
                ]
            ], 500);
        }
    }
    public function destroyOpinion($id){
        try
        {
            $data = Opinion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Opinion'
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
                    'errorMessage' => 'Error deleting Opinion'
                ]
            ], 500);
        }
    }
    public function indexConfiguracion(){
        try
        {
            $Configuracions = Configuracion::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Configuracions'
                ]
            ], 500);
        }

        if($Configuracions)
        {
            $data = [];
            foreach($Configuracions as $Configuracion)
            {
                $types = [];
                $types = [
                    'id'            => $Configuracion->id,
                    'variable'          => $Configuracion->variable,
                    'valor'          => $Configuracion->valor                    
                ];
                $data[] = $types;
            }
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Configuracions was not found'
                ]
            ], 404);
        }
    }
    public function showConfiguracion($id){
        try
        {
            $Configuracion = Configuracion::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Configuracions'
                ]
            ], 500);
        }
        if($Configuracion)
        {
            $data = [];
            $data = [
                'id' => $Configuracion->id,
                'variable' => $Configuracion->variable,
                'valor' => $Configuracion->valor
            ];
        }

        if($data)
        {
            return response()->json([
                'responseCode' => 200,
                'response' => 'OK',
                'data' => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Configuracion was not found'
                ]
            ], 404);
        }
    }
    public function storeConfiguracion(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        $data = new Configuracion();
        if($request->input('variable')){
            $data->variable = $request->input('variable');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'variable no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('valor')){
            $data->valor = $request->input('valor');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'valor no puede estar vacio'
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
                    'errorMessage' => 'Error storing Configuracions'
                ]
            ], 500);
        }
    }
    public function updateConfiguracion($id, Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        try
        {
            $data = Configuracion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Configuracions'
                ]
            ], 500);
        }
        if($request->input('variable')){
            $data->variable = $request->input('variable');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'variable no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('valor')){
            $data->valor = $request->input('valor');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'valor no puede estar vacio'
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
                    'errorMessage' => 'Error updating Configuracions'
                ]
            ], 500);
        }
    }
    public function destroyConfiguracion($id){
        try
        {
            $data = Configuracion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Configuracion'
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
                    'errorMessage' => 'Error deleting Configuracion'
                ]
            ], 500);
        }
    }
    public function login(Request $request){
        if($this->token != $request->input('token')){
            return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
        }
        if($request->input('email')){
            $email = $request->input('email');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'email no puede estar vacio'
                ]
            ], 422);
        }
        if($request->input('password')){
            $password = $request->input('password');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'password no puede estar vacio'
                ]
            ], 422);
        }

        try
        {
            $usuario = User::where('email', $email)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Users'
                ]
            ], 500);
        }
        if(!empty($usuario))
        {
            if (Hash::check($password, $usuario->clave)) {
                $data = [];
                $data = [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'login' => $usuario->login,
                    'email' => $usuario->email,
                    'telefono' => $usuario->telefono,
                    'estatus' => $usuario->estatus,
                    'email_verified' => $usuario->email_verified,
                    'telefono_verified' => $usuario->telefono_verified
                ];
                return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200);
            }
            else {
                return response()->json(['responseCode' => '401','response' => 'Unauthorized'], 401);
            }
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Usuario was not found'
                ]
            ], 404);
        }
    }
}
