<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Pago;
use App\Models\Metodospago;
use App\Models\Tipometodo;
use App\Models\Entrega;
use App\Models\Tipoentrega;
use App\Models\User;
use App\Models\Courier;
use App\Models\Configuracion;
use App\Models\Categoria;
class VentasController extends BaseController
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
    public function indexOrden(){
        try
        {
            $ordenes = Orden::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Ordens'
                ]
            ], 500);
        }
        if($ordenes)
        {
            $data = [];
            foreach($ordenes as $Orden)
            {
                $types = [];
                $types = [
                    'numero' => $Orden->numero,
                    'fecha' => $Orden->fecha,
                    'id_pago' => $Orden->id_pago,
                    'id_usuario' => $Orden->id_usuario,
                    'id_articulo' => $Orden->id_articulo,
                    'cantidad' => $Orden->cantidad,
                    'precio' => $Orden->precio,
                    'id_estatus' => $Orden->id_estatus,
                    'total' => $Orden->total,
                    'id_entrega' => $Orden->id_entrega
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
                    'errorMessage' => 'Ordenes was not found'
                ]
            ], 404);
        }
    }
    public function showOrden($id){
        try
        {
            $Orden = Orden::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Ordens'
                ]
            ], 500);
        }
        if($Orden)
        {
            $data = [];
            $data = [
                'numero' => $Orden->numero,
                'fecha' => $Orden->fecha,
                'id_pago' => $Orden->id_pago,
                'id_usuario' => $Orden->id_usuario,
                'id_articulo' => $Orden->id_articulo,
                'cantidad' => $Orden->cantidad,
                'precio' => $Orden->precio,
                'id_estatus' => $Orden->id_estatus,
                'total' => $Orden->total,
                'id_entrega' => $Orden->id_entrega
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
                    'errorMessage' => 'Orden was not found'
                ]
            ], 404);
        }
    }
    public function storeOrden(Request $request){
        $data = new Orden();

                if($request->input('numero')){
                   $data->numero=$request->input('numero');
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '001',
                          'error' => 'numero no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('fecha')){
                   $data->fecha=$request->input('fecha');
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '002',
                          'error' => 'fecha no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_pago')){
                    if(is_int($request->input('id_pago'))){
                        $data->id_pago=$request->input('id_pago');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_pago debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '003',
                          'error' => 'id_pago no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_usuario')){
                    if(is_int($request->input('id_usuario'))){
                        $data->id_usuario=$request->input('id_usuario');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }   
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '004',
                          'error' => 'id_usuario no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_articulo')){
                    if(is_int($request->input('id_articulo'))){
                        $data->id_articulo=$request->input('id_articulo');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_articulo debe ser numero entero'
                           ]
                        ],422);
                    }  
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '005',
                          'error' => 'id_articulo no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('cantidad')){
                    if(is_int($request->input('cantidad'))){
                        $data->cantidad=$request->input('cantidad');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'cantidad debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '006',
                          'error' => 'cantidad no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('precio')){
                    if(is_float($request->input('precio'))){
                        $data->precio=$request->input('precio');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'precio debe ser numero decimal'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '007',
                          'error' => 'precio no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_estatus')){
                    if(is_int($request->input('id_estatus'))){
                        $data->id_estatus=$request->input('id_estatus');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_estatus debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '008',
                          'error' => 'id_estatus no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('total')){
                    if(is_float($request->input('total'))){
                        $data->total=$request->input('total');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'total debe ser numero decimal'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '009',
                          'error' => 'total no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_entrega')){
                    if(is_int($request->input('id_entrega'))){
                        $data->id_entrega=$request->input('id_entrega');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_entrega debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '010',
                          'error' => 'id_entrega no puede estar vacio'
                       ]
                    ],422);
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
                    'errorMessage' => 'Error storing Ordens'
                ]
            ], 500);
        }
    }
    public function updateOrden($id, Request $request){
        try
        {
            $data = Orden::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Ordens'
                ]
            ], 500);
        }
                if($request->input('numero')){
                   $data->numero=$request->input('numero');
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '001',
                          'error' => 'numero no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('fecha')){
                   $data->fecha=$request->input('fecha');
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '002',
                          'error' => 'fecha no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_pago')){
                    if(is_int($request->input('id_pago'))){
                        $data->id_pago=$request->input('id_pago');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_pago debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '003',
                          'error' => 'id_pago no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_usuario')){
                    if(is_int($request->input('id_usuario'))){
                        $data->id_usuario=$request->input('id_usuario');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }   
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '004',
                          'error' => 'id_usuario no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_articulo')){
                    if(is_int($request->input('id_articulo'))){
                        $data->id_articulo=$request->input('id_articulo');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_articulo debe ser numero entero'
                           ]
                        ],422);
                    }  
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '005',
                          'error' => 'id_articulo no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('cantidad')){
                    if(is_int($request->input('cantidad'))){
                        $data->cantidad=$request->input('cantidad');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'cantidad debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '006',
                          'error' => 'cantidad no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('precio')){
                    if(is_float($request->input('precio'))){
                        $data->precio=$request->input('precio');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'precio debe ser numero decimal'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '007',
                          'error' => 'precio no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_estatus')){
                    if(is_int($request->input('id_estatus'))){
                        $data->id_estatus=$request->input('id_estatus');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_estatus debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '008',
                          'error' => 'id_estatus no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('total')){
                    if(is_float($request->input('total'))){
                        $data->total=$request->input('total');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'total debe ser numero decimal'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '009',
                          'error' => 'total no puede estar vacio'
                       ]
                    ],422);
                }
                if($request->input('id_entrega')){
                    if(is_int($request->input('id_entrega'))){
                        $data->id_entrega=$request->input('id_entrega');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_entrega debe ser numero entero'
                           ]
                        ],422);
                    }
                } else {
                    return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                          'errorCode' => '010',
                          'error' => 'id_entrega no puede estar vacio'
                       ]
                    ],422);
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
                    'errorMessage' => 'Error updating Ordens'
                ]
            ], 500);
        }
    }
    public function destroyOrden($id){
        try
        {
            $data = Orden::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Orden'
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
                    'errorMessage' => 'Error deleting Orden'
                ]
            ], 500);
        }
    }
    public function indexPago(){
        try
        {
            $pagos = Pago::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pagos'
                ]
            ], 500);
        }
        if($pagos)
        {
            $data = [];
            foreach($pagos as $Pago)
            {
                $types = [];
                $types = [
                    'id' => $Pago->id,
                    'referencia' => $Pago->referencia,
                    'fecha' => $Pago->fecha,
                    'id_orden' => $Pago->id_orden,
                    'id_usuario' => $Pago->id_usuario,
                    'monto' => $Pago->monto,
                    'id_estatus' => $Pago->id_estatus,
                    'id_metodo' => $Pago->id_metodo
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
                    'errorMessage' => 'Pagos was not found'
                ]
            ], 404);
        }
    }
    public function showPago($id){
        try
        {
            $Pago = Pago::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pagos'
                ]
            ], 500);
        }
        if($Pago)
        {
            $data = [];
            $data = [
                'id' => $Pago->id,
                'referencia' => $Pago->referencia,
                'fecha' => $Pago->fecha,
                'id_orden' => $Pago->id_orden,
                'id_usuario' => $Pago->id_usuario,
                'monto' => $Pago->monto,
                'id_estatus' => $Pago->id_estatus,
                'id_metodo' => $Pago->id_metodo
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
                    'errorMessage' => 'Pago was not found'
                ]
            ], 404);
        }
    }
    public function storePago(Request $request){
        $data = new Pago();

            if($request->input('referencia')){
                $data->referencia=$request->input('referencia');
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '001',
                              'error' => 'referencia no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('fecha')){
                $data->fecha=$request->input('fecha');
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '002',
                              'error' => 'fecha no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_orden')){
                    if(is_int($request->input('id_orden'))){
                        $data->id_orden=$request->input('id_orden');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_orden debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '004',
                              'error' => 'id_orden no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_usuario')){
                    if(is_int($request->input('id_usuario'))){
                        $data->id_usuario=$request->input('id_usuario');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '005',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '006',
                              'error' => 'id_usuario no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('monto')){
                if(is_float($request->input('monto'))){
                    $data->monto=$request->input('monto');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'monto debe ser numero decimal'
                           ]
                    ],422);
                }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '008',
                              'error' => 'numero no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_estatus')){
                    if(is_int($request->input('id_estatus'))){
                        $data->id_estatus=$request->input('id_estatus');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '009',
                              'error' => 'id_estatus debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '010',
                              'error' => 'id_estatus no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_metodo')){
                    if(is_int($request->input('id_metodo'))){
                        $data->id_metodo=$request->input('id_metodo');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '011',
                              'error' => 'id_metodo debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '012',
                              'error' => 'id_metodo no puede estar vacio'
                             ]
                ],422);
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
                    'errorMessage' => 'Error storing Pagos'
                ]
            ], 500);
        }
    }
    public function updatePago($id, Request $request){
        try
        {
            $data = Pago::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pagos'
                ]
            ], 500);
        }
            if($request->input('referencia')){
                $data->referencia=$request->input('referencia');
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '001',
                              'error' => 'referencia no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('fecha')){
                $data->fecha=$request->input('fecha');
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '002',
                              'error' => 'fecha no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_orden')){
                    if(is_int($request->input('id_orden'))){
                        $data->id_orden=$request->input('id_orden');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '003',
                              'error' => 'id_orden debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '004',
                              'error' => 'id_orden no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_usuario')){
                    if(is_int($request->input('id_usuario'))){
                        $data->id_usuario=$request->input('id_usuario');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '005',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '006',
                              'error' => 'id_usuario no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('monto')){
                if(is_float($request->input('monto'))){
                    $data->monto=$request->input('monto');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'monto debe ser numero decimal'
                           ]
                    ],422);
                }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '008',
                              'error' => 'numero no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_estatus')){
                    if(is_int($request->input('id_estatus'))){
                        $data->id_estatus=$request->input('id_estatus');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '009',
                              'error' => 'id_estatus debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '010',
                              'error' => 'id_estatus no puede estar vacio'
                             ]
                ],422);
            }
            if($request->input('id_metodo')){
                    if(is_int($request->input('id_metodo'))){
                        $data->id_metodo=$request->input('id_metodo');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '011',
                              'error' => 'id_metodo debe ser numero entero'
                           ]
                        ],422);
                    }
            }else{
                return response()->json([
                   'responseCode' => '422',
                   'response' => 'Validation Error',
                   'data' => [
                              'errorCode' => '012',
                              'error' => 'id_metodo no puede estar vacio'
                             ]
                ],422);
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
                    'errorMessage' => 'Error updating Pagos'
                ]
            ], 500);
        }
    }
    public function destroyPago($id){
        try
        {
            $data = Pago::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Pago'
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
                    'errorMessage' => 'Error deleting Pago'
                ]
            ], 500);
        }
    }
    public function indexMetodospago(){
        try
        {
            $Metodospagos = Metodospago::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Metodospagos'
                ]
            ], 500);
        }
        if($Metodospagos)
        {
            $data = [];
            foreach($Metodospagos as $Metodospago)
            {
                $types = [];
                $types = [
                    'id' => $Metodospago->id,
                    'nombre' => $Metodospago->nombre,
                    'descripcion' => $Metodospago->descripcion
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
                    'errorMessage' => 'Metodospagos was not found'
                ]
            ], 404);
        }
    }
    public function showMetodospago($id){
        try
        {
            $Metodospago = Metodospago::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Metodospagos'
                ]
            ], 500);
        }
        if($Metodospago)
        {
            $data = [];
            $data = [
                'id' => $Metodospago->id,
                'nombre' => $Metodospago->nombre,
                'descripcion' => $Metodospago->descripcion
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
                    'errorMessage' => 'Metodospago was not found'
                ]
            ], 404);
        }
    }
    public function storeMetodospago(Request $request){
        $data = new Metodospago();

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
        if($request->input('descripcion')){
            $data->descripcion = $request->input('descripcion');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Descripcion no puede estar vacio'
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
                    'errorMessage' => 'Error storing Metodospagos'
                ]
            ], 500);
        }
    }
    public function updateMetodospago($id, Request $request){
        try
        {
            $data = Metodospago::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Metodospagos'
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
        if($request->input('descripcion')){
            $data->descripcion = $request->input('descripcion');
        }else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                    'errorCode' => '001',
                    'error' => 'Descripcion no puede estar vacio'
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
                    'errorMessage' => 'Error updating Metodospagos'
                ]
            ], 500);
        }
    }
    public function destroyMetodospago($id){
        try
        {
            $data = Metodospago::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Metodospago'
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
                    'errorMessage' => 'Error deleting Metodospago'
                ]
            ], 500);
        }
    }
    public function indexTiposmetodo(){
        try
        {
            $Tiposmetodos = Tipometodo::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tiposmetodos'
                ]
            ], 500);
        }
        if($Tiposmetodos)
        {
            $data = [];
            foreach($Tiposmetodos as $Tiposmetodo)
            {
                $types = [];
                $types = [
                    'id' => $Tiposmetodo->id,
                    'nombre' => $Tiposmetodo->nombre
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
                    'errorMessage' => 'Tiposmetodos was not found'
                ]
            ], 404);
        }
    }
    public function showTiposmetodo($id){
        try
        {
            $Tiposmetodo = Tipometodo::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tiposmetodos'
                ]
            ], 500);
        }
        if($Tiposmetodo)
        {
            $data = [];
            $data = [
                'id' => $Tiposmetodo->id,
                'nombre' => $Tiposmetodo->nombre
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
                    'errorMessage' => 'Tiposmetodo was not found'
                ]
            ], 404);
        }
    }
    public function storeTiposmetodo(Request $request){
        $data = new Tipometodo();

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
                    'errorMessage' => 'Error storing Tiposmetodos'
                ]
            ], 500);
        }
    }
    public function updateTiposmetodo($id, Request $request){
        try
        {
            $data = Tipometodo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tiposmetodos'
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
                    'errorMessage' => 'Error updating Tiposmetodos'
                ]
            ], 500);
        }
    }
    public function destroyTiposmetodo($id){
        try
        {
            $data = Tipometodo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tiposmetodo'
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
                    'errorMessage' => 'Error deleting Tiposmetodo'
                ]
            ], 500);
        }
    }
    public function indexEntrega(){
        try
        {
            $Entregas = Entrega::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entregas'
                ]
            ], 500);
        }
        if($Entregas)
        {
            $data = [];
            foreach($Entregas as $Entrega)
            {
                $types = [];
                $types = [
                    'id' => $Entrega->id,
                    'nombre' => $Entrega->nombre,
                    'id_tipoentrega' => $Entrega->id_tipoentrega,
                    'id_courier' => $Entrega->id_courier,
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
                    'errorMessage' => 'Entregas was not found'
                ]
            ], 404);
        }
    }
    public function showEntrega($id){
        try
        {
            $Entrega = Entrega::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entregas'
                ]
            ], 500);
        }
        if($Entrega)
        {
            $data = [];
            $data = [
                'id' => $Entrega->id,
                'nombre' => $Entrega->nombre,
                'id_tipoentrega' => $Entrega->id_tipoentrega,
                'id_courier' => $Entrega->id_courier,
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
                    'errorMessage' => 'Entrega was not found'
                ]
            ], 404);
        }
    }
    public function storeEntrega(Request $request){
        $data = new Entrega();
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }
        else{
            return response()->json([
                'responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio' ]],422);
        }
        if($request->input('id_tipoentrega')){
                    if(is_int($request->input('id_tipoentrega'))){
                        $data->id_tipoentrega=$request->input('id_tipoentrega');
                    }
                    else{
                        return response()->json(['responseCode' => '422','response' => 'Validation Error',
                        'data' => ['errorCode' => '002','error' => 'id_tipoentrega debe ser numero entero']],422);
                    }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'id_tipoentrega no puede estar vacio']],422);
        }
        if($request->input('id_courier')){
                    if(is_int($request->input('id_courier'))){
                        $data->id_courier=$request->input('id_courier');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '004',
                              'error' => 'id_courier debe ser numero entero'
                           ]
                        ],422);
                    }
        }
        else{
            return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'id_courier no puede estar vacio']],422);
        }
        try 
        {
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        } 
        catch (Exception $e) 
        {
            return response()->json(['responseCode' => '500','response' => 'Internal Server Error','data' => ['errorCode' => 'Error-1','errorMessage' => 'Error storing Entregas']], 500);
        }
    }
    public function updateEntrega($id, Request $request){
        try
        {
            $data = Entrega::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entregas'
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
                           'error' => 'nombre no puede estar vacio'
                          ]
            ],422);
        }
        if($request->input('id_tipoentrega')){
                    if(is_int($request->input('id_tipoentrega'))){
                        $data->id_tipoentrega=$request->input('id_tipoentrega');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '002',
                              'error' => 'id_tipoentrega debe ser numero entero'
                           ]
                        ],422);
                    }
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                           'errorCode' => '003',
                           'error' => 'id_tipoentrega no puede estar vacio'
                          ]
            ],422);
        }
        if($request->input('id_courier')){
                    if(is_int($request->input('id_courier'))){
                        $data->id_courier=$request->input('id_courier');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '004',
                              'error' => 'id_courier debe ser numero entero'
                           ]
                        ],422);
                    }
        }
        else{
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => [
                           'errorCode' => '005',
                           'error' => 'id_courier no puede estar vacio'
                          ]
            ],422);
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
                    'errorMessage' => 'Error updating Entregas'
                ]
            ], 500);
        }
    }
    public function destroyEntrega($id){
        try
        {
            $data = Entrega::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entrega'
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
                    'errorMessage' => 'Error deleting Entrega'
                ]
            ], 500);
        }
    }
    public function indexTipoentrega(){
        try
        {
            $Tipoentregas = Tipoentrega::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipoentregas'
                ]
            ], 500);
        }
        if($Tipoentregas)
        {
            $data = [];
            foreach($Tipoentregas as $Tipoentrega)
            {
                $types = [];
                $types = [
                    'id' => $Tipoentrega->id,
                    'nombre' => $Tipoentrega->nombre
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
                    'errorMessage' => 'Tipoentregas was not found'
                ]
            ], 404);
        }
    }
    public function showTipoentrega($id){
        try
        {
            $Tipoentrega = Tipoentrega::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipoentregas'
                ]
            ], 500);
        }
        if($Tipoentrega)
        {
            $data = [];
            $data = [
                'id' => $Tipoentrega->id,
                'nombre' => $Tipoentrega->nombre
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
                    'errorMessage' => 'Tipoentrega was not found'
                ]
            ], 404);
        }
    }
    public function storeTipoentrega(Request $request){
        $data = new Tipoentrega();

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
                    'errorMessage' => 'Error storing Tipoentregas'
                ]
            ], 500);
        }
    }
    public function updateTipoentrega($id, Request $request){
        try
        {
            $data = Tipoentrega::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipoentregas'
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
                    'errorMessage' => 'Error updating Tipoentregas'
                ]
            ], 500);
        }
    }
    public function destroyTipoentrega($id){
        try
        {
            $data = Tipoentrega::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipoentrega'
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
                    'errorMessage' => 'Error deleting Tipoentrega'
                ]
            ], 500);
        }
    }
    public function indexCourier(){
        try
        {
            $Couriers = Courier::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Couriers'
                ]
            ], 500);
        }
        if($Couriers)
        {
            $data = [];
            foreach($Couriers as $Courier)
            {
                $types = [];
                $types = [
                    'id' => $Courier->id,
                    'nombre' => $Courier->nombre
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
                    'errorMessage' => 'Couriers was not found'
                ]
            ], 404);
        }
    }
    public function showCourier($id){
        try
        {
            $Courier = Courier::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Couriers'
                ]
            ], 500);
        }
        if($Courier)
        {
            $data = [];
            $data = [
                'id' => $Courier->id,
                'nombre' => $Courier->nombre
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
                    'errorMessage' => 'Courier was not found'
                ]
            ], 404);
        }
    }
    public function storeCourier(Request $request){
        $data = new Courier();

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
                    'errorMessage' => 'Error storing Couriers'
                ]
            ], 500);
        }
    }
    public function updateCourier($id, Request $request){
        try
        {
            $data = Courier::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Couriers'
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
                    'errorMessage' => 'Error updating Couriers'
                ]
            ], 500);
        }
    }
    public function destroyCourier($id){
        try
        {
            $data = Courier::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Courier'
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
                    'errorMessage' => 'Error deleting Courier'
                ]
            ], 500);
        }
    }    
}
