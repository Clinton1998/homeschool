<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearProductoRequest;
use App;
use Auth;

class Producto extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
    }

    public function index(){
		$colegio = App\Colegio_m::where([
		    'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
		if(!is_null($colegio) && !empty($colegio)){
			//recuperamos los productos o servicios del colegio, solo los que no estan eliminados
			$productos_o_servicios = App\Producto_servicio_d::where([
				'id_colegio' => $colegio->id_colegio,
				'estado' => 1
			])->orderBy('created_at','DESC')->get();
			//obteniendo los tributos para la creacion de un producto
			$tributos = App\Tributo_m::where('estado','=',1)->orderBy('c_nombre','ASC')->get();
			return view('super.facturacion.productos',compact('productos_o_servicios','tributos'));
		}
    	return redirect('/home');
    }
    public function agregar(CrearProductoRequest $request){
    	//obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=>1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $producto = new App\Producto_servicio_d;
            $producto->c_codigo = $request->input('codigo_producto');
            $producto->c_tipo_codigo = 'MANUAL';
            $producto->c_nombre = $request->input('nombre_producto');
            $producto->c_tipo = $request->input('dd');
        }

        return redirect('/home');
    }
}
