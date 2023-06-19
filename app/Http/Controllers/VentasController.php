<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Pagos;
use App\Models\Metodospago;
use App\Models\Tiposmetodo;
use App\Models\Entrega;
use App\Models\Tipoentrega;
use App\Models\Articulo;
use App\Models\Courier;
use App\Models\Salida;
use App\Models\Movimiento;
use App\Models\User;

class VentasController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $data = Orden::all();
        return response($data);
    }

    public function show($id){
        $data = Orden::where('id', $id)->get();

        if(count($data) > 0){
            return response ($data);
        }else{
            return response('Book not found');
        }
    }

    public function store(Request $request){
        /*$data = new Orden;

        if($request->input('title')){
            $data->title = $request->input('title');
        }else{
            return response('Title canÂ´t be blank');
        }

        if($request->input('author')){
            $data->author = $request->input('author');
        }else{
            return response('Author canÂ´t be blank');
        }
        
        if($request->input('description')){
            $data->description = $request->input('description');
        }else{
            return response('Description canÂ´t be blank');
        }
        
        $data->save();*/

        return response('Successful insert');
    }

    public function update(Request $request, $id){
        $data = Orden::where('id',$id)->first();

       /* if($request->input('title')){
            $data->title = $request->input('title');
        }else{
            return response('Title canÂ´t be blank');
        }

        if($request->input('author')){
            $data->author = $request->input('author');
        }else{
            return response('Author canÂ´t be blank');
        }

        if($request->input('description')){
            $data->description = $request->input('description');
        }else{
            return response('Description canÂ´t be blank');
        }

        $data->save();
    
        return response('Successful update');*/
    }

    public function destroy($id){
        $data = Orden::where('id',$id)->first();
        $data->delete();

        return response('Successful delete');
    }
}
