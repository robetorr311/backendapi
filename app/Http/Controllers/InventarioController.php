<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Imagenarticulo;
use App\Models\Courier;
use App\Models\Entrada;
use App\Models\Existencia;
use App\Models\Salida;
use App\Models\Movimiento;
use App\Models\Tipomovimiento;
use App\Models\Presentacion;
use App\Models\Categoria;
use App\Models\Configuracion;
use App\Models\User;
class InventarioController extends BaseController
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
    public function indexArticulo(){
        try
        {
            $Articulos = Articulo::select(
            'articulo.id as id_articulo',
            'articulo.nombre as nombre',
            'articulo.descripcion as descripcion',
            'articulo.precio_unitario as precio_unitario',
            'articulo.precio_venta as precio_venta',
            'articulo.id_imagen as id_imagen',
            'articulo.codigo as codigo',
            'articulo.id_usuario as id_usuario',
            'imagenarticulo.nombre as imagen',
            'imagenarticulo.url as url',
            'imagenarticulo.alt as alt',
            'categorias.id_categoria as id_categoria',
            'categorias.nombre as categoria',
            'categorias.parent as categoriapadre'
            )->join('inventario.imagenarticulo', 'imagenarticulo.id', '=', 'articulo.id_imagen')->join('comun.categorias', 'categorias.id', '=', 'articulo.id_categoria')->get();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Articulos'
                ]
            ], 500);
        }
        if($Articulos)
        {
            $data = [];
            foreach($Articulos as $Articulo)
            {
                $types = [];
                $types = [
                   'id' => $Articulo->id_articulo,
                   'nombre' => $Articulo->nombre,
                   'descripcion' => $Articulo->descripcion,
                   'precio_unitario' => $Articulo->precio_unitario,
                   'precio_venta' => $Articulo->precio_venta,
                   'id_imagen' => $Articulo->id_imagen,
                   'codigo' => $Articulo->codigo,
                   'id_usuario' => $Articulo->id_usuario,
                   'nombre' => $Articulo->imagen,
                   'url' => $Articulo->url,
                   'alt' => $Articulo->alt,
                   'id_categoria' => $Articulo->id_categoria,
                   'categoria' => $Articulo->categoria,
                   'categoriapadre' => $Articulo->categoriapadre
                ];
                $Imagenarticulo = Imagenarticulo::where('id', $Articulo->id)->first();
                if(!empty($Imagenarticulo)){
                    $types['url'] = $Imagenarticulo->url;
                }
                else {
                    $types['url'] = "";
                }
                $data[] = $types;
            }
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
                    'errorMessage' => 'Articulos was not found'
                ]
            ], 404);
        }
    }
    public function showArticulo($id){
        try
        {
            $Articulos = Articulo::select(
            'articulo.id as id_articulo',
            'articulo.nombre as nombre',
            'articulo.descripcion as descripcion',
            'articulo.precio_unitario as precio_unitario',
            'articulo.precio_venta as precio_venta',
            'articulo.id_imagen as id_imagen',
            'articulo.codigo as codigo',
            'articulo.id_usuario as id_usuario',
            'imagenarticulo.nombre as imagen',
            'imagenarticulo.url as url',
            'imagenarticulo.alt as alt',
            'categorias.id_categoria as id_categoria',
            'categorias.nombre as categoria',
            'categorias.parent as categoriapadre'
            )->join('inventario.imagenarticulo', 'imagenarticulo.id', '=', 'articulo.id_imagen')->join('comun.categorias', 'categorias.id', '=', 'articulo.id_categoria')->where('articulo.id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Articulos'
                ]
            ], 500);
        }
        if($Articulo)
        {
            $data = [];
            $data = [
                   'id' => $Articulo->id_articulo,
                   'nombre' => $Articulo->nombre,
                   'descripcion' => $Articulo->descripcion,
                   'precio_unitario' => $Articulo->precio_unitario,
                   'precio_venta' => $Articulo->precio_venta,
                   'id_imagen' => $Articulo->id_imagen,
                   'codigo' => $Articulo->codigo,
                   'id_usuario' => $Articulo->id_usuario,
                   'nombre' => $Articulo->imagen,
                   'url' => $Articulo->url,
                   'alt' => $Articulo->alt,
                   'id_categoria' => $Articulo->id_categoria,
                   'categoria' => $Articulo->categoria,
                   'categoriapadre' => $Articulo->categoriapadre
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
                    'errorMessage' => 'Articulo was not found'
                ]
            ], 404);
        }
    }
    public function storeArticulo(Request $request){
        $data = new Articulo();

        if($request->input('nombre')){ 
            $data->nombre = $request->input('nombre');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '001',
                          'error' => 'nombre no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('descripcion')){ 
            $data->descripcion = $request->input('descripcion');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '002',
                          'error' => 'descripcion no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('precio_unitario')){ 
                if(is_float($request->input('precio_unitario'))){
                    $data->precio_unitario=$request->input('precio_unitario');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'precio_unitario debe ser numero decimal'
                           ]
                    ],422);
                }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '003',
                          'error' => 'precio_unitario no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('precio_venta')){ 
                if(is_float($request->input('precio_venta'))){
                    $data->precio_venta=$request->input('precio_venta');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'precio_venta debe ser numero decimal'
                           ]
                    ],422);
                }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '004',
                          'error' => 'precio_venta no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('id_imagen')){ 
                    if(is_int($request->input('id_imagen'))){
                        $data->id_imagen=$request->input('id_imagen');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '005',
                              'error' => 'id_imagen debe ser numero entero'
                           ]
                        ],422);
                    }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '006',
                          'error' => 'id_imagen no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('codigo')){ 
            $data->codigo = $request->input('codigo');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '007',
                          'error' => 'codigo no puede estar vacio'
                        ]
            ], 422);
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
                              'errorCode' => '008',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '009',
                          'error' => 'id_usuario no puede estar vacio'
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
                    'errorMessage' => 'Error storing Articulos'
                ]
            ], 500);
        }
    }
    public function updateArticulo($id, Request $request){
        try
        {
            $data = Articulo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Articulos'
                ]
            ], 500);
        }
        if($request->input('nombre')){ 
            $data->nombre = $request->input('nombre');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '001',
                          'error' => 'nombre no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('descripcion')){ 
            $data->descripcion = $request->input('descripcion');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '002',
                          'error' => 'descripcion no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('precio_unitario')){ 
                if(is_float($request->input('precio_unitario'))){
                    $data->precio_unitario=$request->input('precio_unitario');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'precio_unitario debe ser numero decimal'
                           ]
                    ],422);
                }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '003',
                          'error' => 'precio_unitario no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('precio_venta')){ 
                if(is_float($request->input('precio_venta'))){
                    $data->precio_venta=$request->input('precio_venta');
                }
                else{
                    return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '007',
                              'error' => 'precio_venta debe ser numero decimal'
                           ]
                    ],422);
                }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '004',
                          'error' => 'precio_venta no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('id_imagen')){ 
                    if(is_int($request->input('id_imagen'))){
                        $data->id_imagen=$request->input('id_imagen');
                    }
                    else{
                        return response()->json([
                        'responseCode' => '422',
                        'response' => 'Validation Error',
                        'data' => [
                              'errorCode' => '005',
                              'error' => 'id_imagen debe ser numero entero'
                           ]
                        ],422);
                    }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '006',
                          'error' => 'id_imagen no puede estar vacio'
                        ]
            ], 422);
        } 
        if($request->input('codigo')){ 
            $data->codigo = $request->input('codigo');
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '007',
                          'error' => 'codigo no puede estar vacio'
                        ]
            ], 422);
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
                              'errorCode' => '008',
                              'error' => 'id_usuario debe ser numero entero'
                           ]
                        ],422);
                    }
        }else {
            return response()->json([
               'responseCode' => '422',
               'response' => 'Validation Error',
               'data' =>[
                          'errorCode' => '009',
                          'error' => 'id_usuario no puede estar vacio'
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
                    'errorMessage' => 'Error updating Articulos'
                ]
            ], 500);
        }
    }
    public function destroyArticulo($id){
        try
        {
            $data = Articulo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Articulo'
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
                    'errorMessage' => 'Error deleting Articulo'
                ]
            ], 500);
        }
    }
    public function indexImagenarticulo(){
        try
        {
            $Imagenarticulos = Imagenarticulo::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Imagenarticulos'
                ]
            ], 500);
        }
        if($Imagenarticulos)
        {
            $data = [];
            foreach($Imagenarticulos as $Imagenarticulo)
            {
                $types = [];
                $types = [
                    'id' => $Imagenarticulo->id,
                    'nombre' => $Imagenarticulo->nombre,
                    'url' => $Imagenarticulo->url,
                    'alt' => $Imagenarticulo->alt,
                    'id_articulo' => $Imagenarticulo->id_articulo,
                    'id_usuario' => $Imagenarticulo->id_usuario
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
                    'errorMessage' => 'Imagenarticulos was not found'
                ]
            ], 404);
        }
    }
    public function showImagenarticulo($id){
        try
        {
            $Imagenarticulo = Imagenarticulo::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Imagenarticulos'
                ]
            ], 500);
        }
        if($Imagenarticulo)
        {
            $data = [];
            $data = [
                'id' => $Imagenarticulo->id,
                'nombre' => $Imagenarticulo->nombre,
                'url' => $Imagenarticulo->url,
                'alt' => $Imagenarticulo->alt,
                'id_articulo' => $Imagenarticulo->id_articulo,
                'id_usuario' => $Imagenarticulo->id_usuario
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
                    'errorMessage' => 'Imagenarticulo was not found'
                ]
            ], 404);
        }
    }
    public function storeImagenarticulo(Request $request){
        $data = new Imagenarticulo();
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
            ],422);
        }
        if($request->input('url')){
            $data->url = $request->input('url');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'url no puede estar vacio']
            ],422);
        }
        if($request->input('alt')){
            $data->alt = $request->input('alt');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'alt no puede estar vacio']
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
                              'errorCode' => '005',
                              'error' => 'id_articulo debe ser numero entero'
                           ]
                        ],422);
                    }
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'id_articulo no puede estar vacio']
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
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'id_usuario no puede estar vacio']
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
                    'errorMessage' => 'Error storing Imagenarticulos'
                ]
            ], 500);
        }
    }
    public function updateImagenarticulo($id, Request $request){
        try
        {
            $data = Imagenarticulo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Imagenarticulos'
                ]
            ], 500);
        }
        if($request->input('nombre')){
            $data->nombre = $request->input('nombre');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
            ],422);
        }
        if($request->input('url')){
            $data->url = $request->input('url');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'url no puede estar vacio']
            ],422);
        }
        if($request->input('alt')){
            $data->alt = $request->input('alt');
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'alt no puede estar vacio']
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
                              'errorCode' => '005',
                              'error' => 'id_articulo debe ser numero entero'
                           ]
                        ],422);
                    }
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'id_articulo no puede estar vacio']
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
        }
        else {
            return response()->json([
                'responseCode' => '422',
                'response' => 'Validation Error',
                'data' => ['errorCode' => '001', 'error' => 'id_usuario no puede estar vacio']
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
                    'errorMessage' => 'Error updating Imagenarticulos'
                ]
            ], 500);
        }
    }
    public function destroyImagenarticulo($id){
        try
        {
            $data = Imagenarticulo::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Imagenarticulo'
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
                    'errorMessage' => 'Error deleting Imagenarticulo'
                ]
            ], 500);
        }
    }
    public function indexEntrada(){
        try
        {
            $Entradas = Entrada::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entradas'
                ]
            ], 500);
        }
        if(!empty($Entradas))
        {
            $data = [];
            foreach($Entradas as $Entrada)
            {
                $types = [];
                $types = [
                    'id' => $Entrada->id,
                    'nroorden' => $Entrada->nroorden,
                    'factura' => $Entrada->factura,
                    'id_articulo' => $Entrada->id_articulo,
                    'precio_unitario' => $Entrada->precio_unitario,
                    'precio_venta' => $Entrada->precio_venta,
                    'cantidad' => $Entrada->cantidad,
                    'unidades' => $Entrada->unidades,
                    'id_presentacion' => $Entrada->id_presentacion,
                    'fecha' => $Entrada->fecha
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
                    'errorMessage' => 'Entradas was not found'
                ]
            ], 404);
        }
    }
    public function showEntrada($id){
        try
        {
            $Entrada = Entrada::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entradas'
                ]
            ], 500);
        }
        if(!empty($Entrada))
        {
            $data = [];
            $data = [
                'id' => $Entrada->id,
                'nroorden' => $Entrada->nroorden,
                'factura' => $Entrada->factura,
                'id_articulo' => $Entrada->id_articulo,
                'precio_unitario' => $Entrada->precio_unitario,
                'precio_venta' => $Entrada->precio_venta,
                'cantidad' => $Entrada->cantidad,
                'unidades' => $Entrada->unidades,
                'id_presentacion' => $Entrada->id_presentacion,
                'fecha' => $Entrada->fecha
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
                    'errorMessage' => 'Entrada was not found'
                ]
            ], 404);
        }
    }
    public function storeEntrada(Request $request){
        $data = new Entrada();
        if($request->input('nroorden')){ 
            $data->nroorden = $request->input('nroorden');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nroorden no puede estar vacio']
                    ],422);
        }
        if($request->input('factura')){ 
            $data->factura = $request->input('factura');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'factura no puede estar vacio']
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
                            'errorCode' => '007',
                            'error' => 'id_articulo debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        if($request->input('precio_unitario')){ 
            if(is_float($request->input('precio_unitario'))){
                $data->precio_unitario=$request->input('precio_unitario');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'precio_unitario debe ser numero decimal'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'precio_unitario no puede estar vacio']
                    ],422);
        }
        if($request->input('precio_venta')){ 
            if(is_float($request->input('precio_venta'))){
                $data->precio_venta=$request->input('precio_venta');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'precio_venta debe ser numero decimal'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'precio de venta no puede estar vacio']
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
                            'errorCode' => '007',
                            'error' => 'cantidad debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'cantidad no puede estar vacio']
                    ],422);
        }
        if($request->input('id_presentacion')){ 
            if(is_int($request->input('id_presentacion'))){
                $data->id_presentacion=$request->input('id_presentacion');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'id_presentacion debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        if($request->input('fecha')){ 
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        $id_articulo=$request->input('id_articulo');
        $precio_unitario=$request->input('precio_unitario');
        $precio_venta=$request->input('precio_venta');
        $cantidad=$request->input('cantidad');
        $unidades=$request->input('unidades');
        if(!empty($unidades)){
            $data->unidades=$request->input('unidades');
            $entrada_existencia_total=$cantidad*$unidades;
            $entrada_existencia_valor=$precio_venta*$entrada_existencia_total;
        }
        else{
            $entrada_existencia_total=$cantidad;
            $entrada_existencia_valor=$precio_venta*$entrada_existencia_total;            
        }
        $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
        if(!empty($Existencia)){
            $existencia_total=$Existencia->cantidad;
            $existencia_valor=$Existencia->valor;
            $existencia_total_actualizada=$existencia_total+$entrada_existencia_total;
            $existencia_valor_actualizado=$existencia_valor+$entrada_existencia_valor;
            $Existencia->valor=$existencia_valor_actualizado;
            $Existencia->cantidad=$existencia_total_actualizada;
            $Existencia->save();
        }
        else{
            $ent_exist = new Existencia();
            $ent_exist->cantidad=$entrada_existencia_total;
            $ent_exist->valor=$entrada_existencia_valor;
            $ent_exist->id_articulo=$id_articulo;
            $ent_exist->id_presentacion=$request->input('id_presentacion');
            $ent_exist->save();
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
                    'errorMessage' => 'Error storing Entradas'
                ]
            ], 500);
        }
    }
    public function updateEntrada($id, Request $request){
        try
        {
            $data = Entrada::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entradas'
                ]
            ], 500);
        }
        if($data){
            $id_articulo=$data->id_articulo;
            $precio_unitario=$data->precio_unitario;
            $precio_venta=$data->precio_venta;
            $cantidad=$data->cantidad;
            $unidades=$data->unidades;
        }
        if($request->input('nroorden')){ 
            $data->nroorden = $request->input('nroorden');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nroorden no puede estar vacio']
                    ],422);
        }
        if($request->input('factura')){ 
            $data->factura = $request->input('factura');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'factura no puede estar vacio']
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
                            'errorCode' => '007',
                            'error' => 'id_articulo debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        if($request->input('precio_unitario')){ 
            if(is_float($request->input('precio_unitario'))){
                $data->precio_unitario=$request->input('precio_unitario');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'precio_unitario debe ser numero decimal'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'precio_unitario no puede estar vacio']
                    ],422);
        }
        if($request->input('precio_venta')){ 
            if(is_float($request->input('precio_venta'))){
                $data->precio_venta=$request->input('precio_venta');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'precio_venta debe ser numero decimal'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'precio de venta no puede estar vacio']
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
                            'errorCode' => '007',
                            'error' => 'cantidad debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'cantidad no puede estar vacio']
                    ],422);
        }
        if($request->input('unidades')){ 
            if(is_int($request->input('unidades'))){
                $data->unidades=$request->input('unidades');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'unidades debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'unidades no puede estar vacio']
                    ],422);
        }
        if($request->input('id_presentacion')){ 
            if(is_int($request->input('id_presentacion'))){
                $data->id_presentacion=$request->input('id_presentacion');
            }
            else{
                return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => [
                            'errorCode' => '007',
                            'error' => 'id_presentacion debe ser numero entero'
                        ]
                ],422);
            }
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        if($request->input('fecha')){ 
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json([
                    'responseCode' => '422',
                    'response' => 'Validation Error',
                    'data' => ['errorCode' => '001', 'error' => 'nombre no puede estar vacio']
                    ],422);
        }
        $new_id_articulo=$request->input('id_articulo');
        $new_precio_unitario=$request->input('precio_unitario');
        $new_precio_venta=$request->input('precio_venta');
        $new_cantidad=$request->input('cantidad');
        $new_unidades=$request->input('unidades');
        if(!empty($unidades)){
            $data->unidades=$request->input('unidades');
            $old_entrada_existencia_total=$cantidad*$unidades;
            $old_entrada_existencia_valor=$precio_venta*$old_entrada_existencia_total;            
            $new_entrada_existencia_total=$new_cantidad*$new_unidades;
            $new_entrada_existencia_valor=$new_precio_venta*$new_entrada_existencia_total;
        }
        else{
            $old_entrada_existencia_total=$cantidad;
            $old_entrada_existencia_valor=$precio_venta*$existencia_total;
            $new_entrada_existencia_total=$new_cantidad;
            $new_entrada_existencia_valor=$new_precio_venta*$new_existencia_total;                         
        }        
        if($new_id_articulo==$id_articulo){
            $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($Existencia)){
                $existencia_total=$Existencia->cantidad;
                $existencia_valor=$Existencia->valor;
                $existencia_total_ajuste=$existencia_total-$old_entrada_existencia_total;
                $existencia_valor_ajuste=$existencia_valor-$old_entrada_existencia_valor;
                $existencia_total_actualizada=$existencia_total_ajuste+$new_entrada_existencia_total;
                $existencia_valor_actualizado=$existencia_valor_ajuste+$new_entrada_existencia_valor;
                $Existencia->valor=$existencia_valor_actualizado;
                $Existencia->cantidad=$existencia_total_actualizada;
                $Existencia->save();
            }
            else{
                $ent_exist = new Existencia();
                $ent_exist->cantidad=$entrada_existencia_total;
                $ent_exist->valor=$entrada_existencia_valor;
                $ent_exist->id_articulo=$id_articulo;
                $ent_exist->id_presentacion=$request->input('id_presentacion');
                $ent_exist->save();
            }             
        }
        else{
            $OldExistencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($OldExistencia)){
                $existencia_total=$OldExistencia->cantidad;
                $existencia_valor=$OldExistencia->valor;
                $existencia_total_ajuste=$existencia_total-$old_entrada_existencia_total;
                $existencia_valor_ajuste=$existencia_valor-$old_entrada_existencia_valor;
                $OldExistencia->valor=$existencia_total_ajuste;
                $OldExistencia->cantidad=$existencia_valor_ajuste;
                $OldExistencia->save();
            }
            $NewExistencia = Existencia::where('id_articulo', $new_id_articulo)->first();
            if(!empty($NewExistencia)){
                $existencia_total=$NewExistencia->cantidad;
                $existencia_valor=$NewExistencia->valor;
                $existencia_total_actualizada=$existencia_total+$new_entrada_existencia_total;
                $existencia_valor_actualizado=$existencia_valor+$new_entrada_existencia_valor;
                $NewExistencia->valor=$existencia_valor_actualizado;
                $NewExistencia->cantidad=$existencia_total_actualizada;
                $NewExistencia->save();
            }
            else{
                $ent_exist = new Existencia();
                $ent_exist->cantidad=$new_entrada_existencia_total;
                $ent_exist->valor=$new_entrada_existencia_valor;
                $ent_exist->id_articulo=$new_id_articulo;
                $ent_exist->id_presentacion=$request->input('id_presentacion');
                $ent_exist->save();
            }  
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
                    'errorMessage' => 'Error updating Entradas'
                ]
            ], 500);
        }
    }
    public function destroyEntrada($id){
        try
        {
            $data = Entrada::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Entrada'
                ]
            ], 500);
        }
        if(!empty($data)){
            $id_articulo=$data->id_articulo;
            $precio_unitario=$data->precio_unitario;
            $precio_venta=$data->precio_venta;
            if($data->unidades>1){
                $cantidad=$data->cantidad*$data->unidades;
                $existencia_salida=$precio_venta*$cantidad;
            }
            else{ 
                $cantidad=$data->cantidad;
                $existencia_salida=$precio_venta*$cantidad;
            }
            $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($Existencia)){
                $existencia_cantidad_total = $Existencia->cantidad;
                $existencia_valor_total = $Existencia->valor;
                $new_existencia_cantidad_total = $existencia_cantidad_total-$cantidad;
                $new_existencia_valor_total = $existencia_valor_total-$existencia_salida;
                $Existencia->cantidad=$new_existencia_cantidad_total;
                $Existencia->valor=$new_existencia_valor_total;
                $Existencia->save();
            }
            $Movimiento = Movimiento::where('id_entrada', $id)->first();
            if(!empty($Movimiento)){
                $movimiento->id_estatus=2;
                $Movimiento->save();
            }
            $data->id_estatus=2;
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        }
        else {
            return response()->json(['responseCode' => '404','response' => 'Error','data' => ['errorCode' => '404','error' => 'Entrada no encontrada']],404);
        }
    }
    public function indexSalida(){
        try
        {
            $Salidas = Salida::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Salidas'
                ]
            ], 500);
        }
        if(!empty($Salidas))
        {
            $data = [];
            foreach($Salidas as $Salida)
            {
                $types = [];
                $types = [
                    'id' => $Salida->id,
                    'nroorden' => $Salida->nroorden,
                    'referencia' => $Salida->referencia,
                    'id_articulo' => $Salida->id_articulo,
                    'precio_venta' => $Salida->precio_venta,
                    'cantidad' => $Salida->cantidad,
                    'id_venta' => $Salida->id_venta,
                    'id_usuario' => $Salida->id_usuario,
                    'fecha' => $Salida->fecha
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
                    'errorMessage' => 'Salidas was not found'
                ]
            ], 404);
        }
    }
    public function showSalida($id){
        try
        {
            $Salida = Salida::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Salidas'
                ]
            ], 500);
        }
        if(!empty($Salida))
        {
            $data = [];
            $data = [
                'id' => $Salida->id,
                'nroorden' => $Salida->nroorden,
                'referencia' => $Salida->referencia,
                'id_articulo' => $Salida->id_articulo,
                'precio_venta' => $Salida->precio_venta,
                'cantidad' => $Salida->cantidad,
                'id_venta' => $Salida->id_venta,
                'id_usuario' => $Salida->id_usuario,
                'fecha' => $Salida->fecha
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
                    'errorMessage' => 'Salida was not found'
                ]
            ], 404);
        }
    }
    public function storeSalida(Request $request){
        $data = new Salida();

        if($request->input('nroorden')){ 
            $data->nroorden = $request->input('nroorden');
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '001', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('referencia')){ 
            $data->referencia = $request->input('referencia');
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('id_articulo')){ 
            if(is_int($request->input('id_articulo'))){
                $data->id_articulo=$request->input('id_articulo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'id_articulo debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '004', 'error' => 'id_articulo no puede estar vacio']],422);
        }
        if($request->input('precio_venta')){ 
            if(is_float($request->input('precio_venta'))){
                $data->precio_venta=$request->input('precio_venta');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'precio_venta debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '006', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('cantidad')){ 
            if(is_int($request->input('cantidad'))){
                $data->cantidad=$request->input('cantidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'cantidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '008', 'error' => 'cantidad no puede estar vacio']],422);
        }
        if($request->input('id_venta')){ 
            if(is_int($request->input('id_venta'))){
                $data->id_venta=$request->input('id_venta');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'id_venta debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '010', 'error' => 'id_venta no puede estar vacio']],422);
        }
        if($request->input('id_usuario')){ 
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '012', 'error' => 'id_usuario no puede estar vacio']],422);
        }
        if($request->input('fecha')){ 
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '013', 'error' => 'fecha no puede estar vacio']],422);
        }
        $id_articulo=$request->input('id_articulo');
        $precio_unitario=$request->input('precio_unitario');
        $precio_venta=$request->input('precio_venta');
        $cantidad=$request->input('cantidad');
        $unidades=$request->input('unidades');
        if(!empty($unidades)){
            $data->unidades=$request->input('unidades');
            $salida_existencia_total=$cantidad*$unidades;
            $salida_existencia_valor=$precio_venta*$salida_existencia_total;
        }
        else{
            $salida_existencia_total=$cantidad;
            $salida_existencia_valor=$precio_venta*$salida_existencia_total;            
        }
        $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
        if(!empty($Existencia)){
            $existencia_total=$Existencia->cantidad;
            $existencia_valor=$Existencia->valor;
            if($existencia_total>=$salida_existencia_total){
                $existencia_total_actualizada=$existencia_total-$salida_existencia_total;
                $existencia_valor_actualizado=$existencia_valor-$salida_existencia_valor;
                $Existencia->valor=$existencia_valor_actualizado;
                $Existencia->cantidad=$existencia_total_actualizada;
                $Existencia->save();
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'Inventario Insuficiente']],422);
            }
        }
        else{
            return response()->json(['responseCode' => '404','response' => 'Error','data' => ['errorCode' => '$)$','Error' => 'No existe el articulo en existencia']],404);
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
                    'errorMessage' => 'Error storing Salidas'
                ]
            ], 500);
        }
    }
    public function updateSalida($id, Request $request){
        try
        {
            $data = Salida::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Salidas'
                ]
            ], 500);
        }
        if($data){
            $id_articulo=$data->id_articulo;
            $precio_unitario=$data->precio_unitario;
            $precio_venta=$data->precio_venta;
            $cantidad=$data->cantidad;
            $unidades=$data->unidades;
        }        
        if($request->input('nroorden')){ 
            $data->nroorden = $request->input('nroorden');
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '001', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('referencia')){ 
            $data->referencia = $request->input('referencia');
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('id_articulo')){ 
            if(is_int($request->input('id_articulo'))){
                $data->id_articulo=$request->input('id_articulo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'id_articulo debe ser numero entero']],422);
            }
        } else {
           return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '004', 'error' => 'id_articulo no puede estar vacio']],422);
        }
        if($request->input('precio_venta')){ 
            if(is_float($request->input('precio_venta'))){
                $data->precio_venta=$request->input('precio_venta');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'precio_venta debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '006', 'error' => 'Nombre no puede estar vacio']],422);
        }
        if($request->input('cantidad')){ 
            if(is_int($request->input('cantidad'))){
                $data->cantidad=$request->input('cantidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'cantidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '008', 'error' => 'cantidad no puede estar vacio']],422);
        }
        if($request->input('id_venta')){ 
            if(is_int($request->input('id_venta'))){
                $data->id_venta=$request->input('id_venta');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'id_venta debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '010', 'error' => 'id_venta no puede estar vacio']],422);
        }
        if($request->input('id_usuario')){ 
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '012', 'error' => 'id_usuario no puede estar vacio']],422);
        }
        if($request->input('fecha')){ 
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '013', 'error' => 'fecha no puede estar vacio']],422);
        }
        $new_id_articulo=$request->input('id_articulo');
        $new_precio_unitario=$request->input('precio_unitario');
        $new_precio_venta=$request->input('precio_venta');
        $new_cantidad=$request->input('cantidad');
        $new_unidades=$request->input('unidades');
        if(!empty($unidades)){
            $data->unidades=$request->input('unidades');
            $old_salida_existencia_total=$cantidad*$unidades;
            $old_salida_existencia_valor=$precio_venta*$old_salida_existencia_total;            
            $new_salida_existencia_total=$new_cantidad*$new_unidades;
            $new_salida_existencia_valor=$new_precio_venta*$new_salida_existencia_total;
        }
        else{
            $old_salida_existencia_total=$cantidad;
            $old_salida_existencia_valor=$precio_venta*$old_salida_existencia_total;
            $new_salida_existencia_total=$new_cantidad;
            $new_salida_existencia_valor=$new_precio_venta*$new_salida_existencia_total;                         
        }        
        if($new_id_articulo==$id_articulo){
            $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($Existencia)){
                $existencia_total=$Existencia->cantidad;
                $existencia_valor=$Existencia->valor;
                if($existencia_total>=$new_salida_existencia_total){
                    $existencia_total_ajuste=$existencia_total+$old_salida_existencia_total;
                    $existencia_valor_ajuste=$existencia_valor+$old_salida_existencia_valor;
                    $existencia_total_actualizada=$existencia_total_ajuste-$new_salida_existencia_total;
                    $existencia_valor_actualizado=$existencia_valor_ajuste-$new_salida_existencia_valor;
                    $Existencia->valor=$existencia_valor_actualizado;
                    $Existencia->cantidad=$existencia_total_actualizada;
                    $Existencia->save();
                }
                else{
                    return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'Inventario Insuficiente']],422);
                }
            }
            else{
                return response()->json(['responseCode' => '404','response' => 'Error','data' => ['errorCode' => '404','error' => 'No existe el articulo en existencia']],404);
            }             
        }
        else{
            $OldExistencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($OldExistencia)){
                $existencia_total=$OldExistencia->cantidad;
                $existencia_valor=$OldExistencia->valor;
                $existencia_total_ajuste=$existencia_total+$old_salida_existencia_total;
                $existencia_valor_ajuste=$existencia_valor+$old_salida_existencia_valor;
                $OldExistencia->valor=$existencia_total_ajuste;
                $OldExistencia->cantidad=$existencia_valor_ajuste;
                $OldExistencia->save();
            }
            $NewExistencia = Existencia::where('id_articulo', $new_id_articulo)->first();
            if(!empty($NewExistencia)){
                $existencia_total=$NewExistencia->cantidad;
                $existencia_valor=$NewExistencia->valor;
                if($existencia_total>=$new_salida_existencia_total){
                    $existencia_total_actualizada=$existencia_total-$new_salida_existencia_total;
                    $existencia_valor_actualizado=$existencia_valor-$new_salida_existencia_valor;
                    $NewExistencia->valor=$existencia_valor_actualizado;
                    $NewExistencia->cantidad=$existencia_total_actualizada;
                    $NewExistencia->save();
                }
                else{
                    return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'Inventario Insuficiente']],422);
                }
            }
            else{
                return response()->json(['responseCode' => '404','response' => 'Error','data' => ['errorCode' => '404','error' => 'No existe el articulo en existencia']],404);
            }    
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
                    'errorMessage' => 'Error updating Salidas'
                ]
            ], 500);
        }
    }
    public function destroySalida($id){
        try
        {
            $data = Salida::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => ['errorCode' => 'Error-1','errorMessage' => 'Error getting Salida']], 500);
        }
        if(!empty($data)){
            $id_articulo=$data->id_articulo;
            $precio_unitario=$data->precio_unitario;
            $precio_venta=$data->precio_venta;
            $cantidad=$data->cantidad;
            $existencia_salida=$precio_venta*$cantidad;
            $Existencia = Existencia::where('id_articulo', $id_articulo)->first();
            if(!empty($Existencia)){
                $existencia_cantidad_total = $Existencia->cantidad;
                $existencia_valor_total = $Existencia->valor;
                $new_existencia_cantidad_total = $existencia_cantidad_total+$cantidad;
                $new_existencia_valor_total = $existencia_valor_total+$existencia_salida;
                $Existencia->cantidad=$new_existencia_cantidad_total;
                $Existencia->valor=$new_existencia_valor_total;
                $Existencia->save();
            }
            $Movimiento = Movimiento::where('id_salida', $id)->first();
            if(!empty($Movimiento)){
                $movimiento->id_estatus=2;
                $Movimiento->save();
            }
            $data->id_estatus=2;
            $data->save();
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        }
        else {
            return response()->json(['responseCode' => '404','response' => 'Error','data' => ['errorCode' => '404','error' => 'Salida no encontrada']],404);
        }
    }
    public function indexMovimiento(){
        try
        {
            $Movimientos = Movimiento::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Movimientos'
                ]
            ], 500);
        }
        if(!empty($Movimientos))
        {
            $data=[];
            foreach($Movimientos as $Movimiento)
            {
                $types = [];
                $types = [
                    'id' => $Movimiento->id,
                    'id_tipomovimiento' => $Movimiento->id_tipomovimiento,
                    'id_articulo' => $Movimiento->id_articulo,
                    'cantidad' => $Movimiento->cantidad,
                    'valor' => $Movimiento->valor,
                    'id_entrada' => $Movimiento->id_entrada,
                    'id_salida' => $Movimiento->id_salida,
                    'fecha' => $Movimiento->fecha,
                    'id_usuario' => $Movimiento->id_usuario
                ];
                $data[] = $types;
            }
            return response()->json(['responseCode' => '200','response' => 'OK','data' => $data], 200);
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Movimientos was not found'
                ]
            ], 404);
        }
    }
    public function showMovimiento($id){
        try
        {
            $Movimiento = Movimiento::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Movimientos'
                ]
            ], 500);
        }
        if(!empty($Movimiento))
        {
            $data=[];
            $data = [
                    'id' => $Movimiento->id,
                    'id_tipomovimiento' => $Movimiento->id_tipomovimiento,
                    'id_articulo' => $Movimiento->id_articulo,
                    'cantidad' => $Movimiento->cantidad,
                    'valor' => $Movimiento->valor,
                    'id_entrada' => $Movimiento->id_entrada,
                    'id_salida' => $Movimiento->id_salida,
                    'fecha' => $Movimiento->fecha,
                    'id_usuario' => $Movimiento->id_usuario
            ];
            return response()->json(['responseCode' => 200, 'response' => 'OK', 'data' => $data], 200); 
        }
        else
        {
            return response()->json([
                'responseCode' => 404,
                'response' => 'Not Found',
                'data' => [
                    'errorCode' => 'Error-2',    
                    'errorMessage' => 'Movimiento was not found'
                ]
            ], 404);
        }
    }
    public function storeMovimiento(Request $request){
        $data = new Movimiento();

        if($request->input('id_tipomovimiento')){
            if(is_int($request->input('id_tipomovimiento'))){
                $data->id_tipomovimiento=$request->input('id_tipomovimiento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_tipomovimiento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'id_tipomovimiento no puede estar vacio']],422);
        }
        if($request->input('id_articulo')){
            if(is_int($request->input('id_articulo'))){
                $data->id_articulo=$request->input('id_articulo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'id_articulo debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '004', 'error' => 'id_articulo no puede estar vacio']],422);
        }
        if($request->input('cantidad')){
            if(is_int($request->input('cantidad'))){
                $data->cantidad=$request->input('cantidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'cantidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '006', 'error' => 'cantidad no puede estar vacio']],422);
        }
        if($request->input('valor')){
            if(is_float($request->input('valor'))){
                $data->valor=$request->input('valor');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'valor debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '008', 'error' => 'valor no puede estar vacio']],422);
        }
        if($request->input('id_entrada')){
            if(is_int($request->input('id_entrada'))){
                $data->id_entrada=$request->input('id_entrada');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'id_entrada debe ser numero entero']],422);
            }
        }
        if($request->input('id_salida')){
            if(is_int($request->input('id_salida'))){
                $data->id_salida=$request->input('id_salida');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'id_salida debe ser numero entero']],422);
            }
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '013', 'error' => 'fecha no puede estar vacio']],422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '015', 'error' => 'id_usuario no puede estar vacio']],422);
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
                    'errorMessage' => 'Error storing Movimientos'
                ]
            ], 500);
        }
    }
    public function updateMovimiento($id, Request $request){
        try
        {
            $data = Movimiento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Movimientos'
                ]
            ], 500);
        }
        if($request->input('id_tipomovimiento')){
            if(is_int($request->input('id_tipomovimiento'))){
                $data->id_tipomovimiento=$request->input('id_tipomovimiento');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '001','error' => 'id_tipomovimiento debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '002', 'error' => 'id_tipomovimiento no puede estar vacio']],422);
        }
        if($request->input('id_articulo')){
            if(is_int($request->input('id_articulo'))){
                $data->id_articulo=$request->input('id_articulo');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '003','error' => 'id_articulo debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '004', 'error' => 'id_articulo no puede estar vacio']],422);
        }
        if($request->input('cantidad')){
            if(is_int($request->input('cantidad'))){
                $data->cantidad=$request->input('cantidad');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '005','error' => 'cantidad debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '006', 'error' => 'cantidad no puede estar vacio']],422);
        }
        if($request->input('valor')){
            if(is_float($request->input('valor'))){
                $data->valor=$request->input('valor');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '007','error' => 'valor debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '008', 'error' => 'valor no puede estar vacio']],422);
        }
        if($request->input('id_entrada')){
            if(is_int($request->input('id_entrada'))){
                $data->id_entrada=$request->input('id_entrada');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '009','error' => 'id_entrada debe ser numero entero']],422);
            }
        }
        if($request->input('id_salida')){
            if(is_int($request->input('id_salida'))){
                $data->id_salida=$request->input('id_salida');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '011','error' => 'id_salida debe ser numero entero']],422);
            }
        }
        if($request->input('fecha')){
            $data->fecha = $request->input('fecha');
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '013', 'error' => 'fecha no puede estar vacio']],422);
        }
        if($request->input('id_usuario')){
            if(is_int($request->input('id_usuario'))){
                $data->id_usuario=$request->input('id_usuario');
            }
            else{
                return response()->json(['responseCode' => '422','response' => 'Validation Error','data' => ['errorCode' => '014','error' => 'id_usuario debe ser numero entero']],422);
            }
        } else {
            return response()->json(['responseCode' => '422', 'response' => 'Validation Error', 'data' => ['errorCode' => '015', 'error' => 'id_usuario no puede estar vacio']],422);
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
                    'errorMessage' => 'Error updating Movimientos'
                ]
            ], 500);
        }
    }
    public function destroyMovimiento($id){
        try
        {
            $data = Movimiento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Movimiento'
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
                    'errorMessage' => 'Error deleting Movimiento'
                ]
            ], 500);
        }
    }
    public function indexTipomovimiento(){
        try
        {
            $Tipomovimientos = Tipomovimiento::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipomovimientos'
                ]
            ], 500);
        }
        if($Tipomovimientos)
        {
            $data = [];
            foreach($Tipomovimientos as $Tipomovimiento)
            {
                $types = [];
                $types = [
                    'id' => $Tipomovimiento->id,
                    'nombre' => $Tipomovimiento->nombre
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
                    'errorMessage' => 'Tipomovimientos was not found'
                ]
            ], 404);
        }
    }
    public function showTipomovimiento($id){
        try
        {
            $Tipomovimiento = Tipomovimiento::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipomovimientos'
                ]
            ], 500);
        }
        if($Tipomovimiento)
        {
            $data = [];
            $data = [
                'id' => $Tipomovimiento->id,
                'nombre' => $Tipomovimiento->nombre
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
                    'errorMessage' => 'Tipomovimiento was not found'
                ]
            ], 404);
        }
    }
    public function storeTipomovimiento(Request $request){
        $data = new Tipomovimiento();

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
                    'errorMessage' => 'Error storing Tipomovimientos'
                ]
            ], 500);
        }
    }
    public function updateTipomovimiento($id, Request $request){
        try
        {
            $data = Tipomovimiento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipomovimientos'
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
                    'errorMessage' => 'Error updating Tipomovimientos'
                ]
            ], 500);
        }
    }
    public function destroyTipomovimiento($id){
        try
        {
            $data = Tipomovimiento::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Tipomovimiento'
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
                    'errorMessage' => 'Error deleting Tipomovimiento'
                ]
            ], 500);
        }
    }
    public function indexPresentacion(){
        try
        {
            $Presentacions = Presentacion::all();
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
    public function showPresentacion($id){
        try
        {
            $Presentacion = Presentacion::where('id', $id)->first();
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
        if($Presentacion)
        {
            $data = [];
            $data = [
                'id' => $Presentacion->id,
                'nombre' => $Presentacion->nombre
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
                    'errorMessage' => 'Presentacion was not found'
                ]
            ], 404);
        }
    }
    public function storePresentacion(Request $request){
        $data = new Presentacion();

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
                    'errorMessage' => 'Error storing Presentacions'
                ]
            ], 500);
        }
    }
    public function updatePresentacion($id, Request $request){
        try
        {
            $data = Presentacion::where('id',$id)->first();
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
                    'errorMessage' => 'Error updating Presentacions'
                ]
            ], 500);
        }
    }
    public function destroyPresentacion($id){
        try
        {
            $data = Presentacion::where('id',$id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Presentacion'
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
                    'errorMessage' => 'Error deleting Presentacion'
                ]
            ], 500);
        }
    }
    public function indexExistencia(){
        try
        {
            $Existencias = Existencia::all();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Existencias'
                ]
            ], 500);
        }
        if($Existencias)
        {
            $data = [];
            foreach($Existencias as $Existencia)
            {
                $types = [];
                $types = [
                    'id' => $Existencia->id,
                    'cantidad' => $Existencia->cantidad,
                    'valor' => $Existencia->valor,
                    'id_articulo' => $Existencia->id_articulo,
                    'id_presentacion' => $Existencia->id_presentacion                    
                ];
                $Articulo = Articulo::where('id', $Existencia->id_articulo)->first();
                if(!empty($Articulo)){
                    $types['nombre_articulo']=$Articulo->nombre;
                }
                $Presentacion = Presentacion::where('id', $Existencia->id_presentacion)->first();
                if(!empty($Presentacion)){
                    $types['presentacion_fisica']=$Presentacion->nombre;
                }
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
                    'errorMessage' => 'Existencias was not found'
                ]
            ], 404);
        }
    }
    public function showExistencia($id){
        try
        {
            $Existencia = Existencia::where('id', $id)->first();
        }
        catch (Exception $e)
        {
            return response()->json([
                'responseCode' => '500',
                'response' => 'Internal Server Error',
                'data' => [
                    'errorCode' => 'Error-1',
                    //"exception" => $e->getMessage(),
                    'errorMessage' => 'Error getting Existencias'
                ]
            ], 500);
        }
        if($Existencia)
        {
            $data = [];
            $data = [
                'id' => $Existencia->id,
                'nombre' => $Existencia->nombre
            ];
            $Articulo = Articulo::where('id', $Existencia->id_articulo)->first();
            if(!empty($Articulo)){
                $data['nombre_articulo']=$Articulo->nombre;
            }
            $Presentacion = Presentacion::where('id', $Existencia->id_presentacion)->first();
            if(!empty($Presentacion)){
                $data['presentacion_fisica']=$Presentacion->nombre;
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
                    'errorMessage' => 'Existencia was not found'
                ]
            ], 404);
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
}
