<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Configuracion;
class DulcepaladarController extends BaseController
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
    public function showConfiguracion($id){
        try
        {
            $Presentacions = Configuracion::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Presentacions'
                ]
            ], 500);
        }
        if($Presentacions)
        {
            $data = [];
            foreach($Presentacions as $Presentacion)
            {
                $types = [];
                $types = [
                    'id' => $Presentacion->id,
                    'nombre' => $Presentacion->nombre
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
                    'errorMessage' => 'Presentacions was not found'
                ]
            ], 404);
        }
    }
   
}
