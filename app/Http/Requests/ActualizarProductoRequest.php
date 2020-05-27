<?php

namespace App\Http\Requests;

use App\Producto_servicio_d;
use Illuminate\Foundation\Http\FormRequest;
use App\Colegio_m;
use Auth;
class ActualizarProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $nombre_producto = trim($this->nombre);
        $codigo_producto = trim($this->codigo);
        $colegio = Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' =>1
        ])->first();
        $id_colegio = $colegio->id_colegio;

        //aplicamos el productos
        $producto = Producto_servicio_d::where([
            'id_producto_servicio' => $this->id_producto,
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->first();
        //verificamos si el codigo del producto a cambiado
        if((string)$producto->c_codigo!==(string)$codigo_producto && (string)$producto->c_nombre!==(string)$nombre_producto){
            //validamos que el codigo y nombre no se repita
            return [
                'id_producto' => 'required|numeric',
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_nombre,'.$nombre_producto,
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_codigo,'.$codigo_producto,
                'tipo'=> 'required|min:8|max:8',
                'nombre' => 'required|unique:producto_servicio_d,c_nombre,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'codigo' => 'required|unique:producto_servicio_d,c_codigo,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'tributo'=> 'required|numeric',
                'unidad' => 'required|max:191',
                'unidad_sunat' =>'required|max:191',
                'precio_sin_igv'=> 'required|numeric|min:0',
                'precio_con_igv'=> 'required|numeric|min:0',
            ];
        }else if((string)$producto->c_codigo===(string)$codigo_producto && (string)$producto->c_nombre!==(string)$nombre_producto){
            //validamos que el nombre del producto no se repita
            return [
                'id_producto' => 'required|numeric',
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_nombre,'.$nombre_producto,
                'tipo'=> 'required|min:8|max:8',
                'nombre' => 'required|unique:producto_servicio_d,c_nombre,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'codigo' => 'required|max:191',
                'tributo'=> 'required|numeric',
                'unidad' => 'required|max:191',
                'unidad_sunat' =>'required|max:191',
                'precio_sin_igv'=> 'required|numeric|min:0',
                'precio_con_igv'=> 'required|numeric|min:0',
            ];
        }else if((string)$producto->c_codigo!==(string)$codigo_producto && (string)$producto->c_nombre===(string)$nombre_producto){
            //validamos que el codigo no se repita
            return [
                'id_producto' => 'required|numeric',
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_codigo,'.$codigo_producto,
                'tipo'=> 'required|min:8|max:8',
                'nombre' => 'required|max:191',
                'codigo' => 'required|unique:producto_servicio_d,c_codigo,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'tributo'=> 'required|numeric',
                'unidad' => 'required|max:191',
                'unidad_sunat' =>'required|max:191',
                'precio_sin_igv'=> 'required|numeric|min:0',
                'precio_con_igv'=> 'required|numeric|min:0',
            ];
        }else{
            return [
                'id_producto' => 'required|numeric',
                'tipo'=> 'required|min:8|max:8',
                'nombre' => 'required|max:191',
                'codigo' => 'required|max:191',
                'tributo'=> 'required|numeric',
                'unidad' => 'required|max:191',
                'unidad_sunat' =>'required|max:191',
                'precio_sin_igv'=> 'required|numeric|min:0',
                'precio_con_igv'=> 'required|numeric|min:0',
            ];
        }
    }
}
