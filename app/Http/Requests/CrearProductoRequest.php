<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Colegio_m;
use Auth;

class CrearProductoRequest extends FormRequest
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
        $nombre_producto = trim($this->nombre_producto);
        $codigo_producto = trim($this->codigo_producto);
        $colegio = Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' =>1
        ])->first();
        $id_colegio = $colegio->id_colegio;

        if(isset($this->modo_codigo_producto)){
            return [
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_nombre,'.$nombre_producto,
                'tipo_producto'=> 'required|min:8|max:8',
                'nombre_producto' => 'required|unique:producto_servicio_d,c_nombre,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'tributo_producto'=> 'required|numeric',
                'unidad_producto' => 'required|max:191',
                'unidad_sunat_producto' =>'required|max:191',
                'precio_producto_sin_igv'=> 'required|numeric|min:0',
                'precio_producto_con_igv'=> 'required|numeric|min:0',
            ];
        }else{
            return [
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_nombre,'.$nombre_producto,
                'id_colegio' => 'unique:producto_servicio_d,id_colegio,NULL,id_producto_servicio,c_codigo,'.$codigo_producto,
                'tipo_producto'=> 'required|min:8|max:8',
                'nombre_producto' => 'required|unique:producto_servicio_d,c_nombre,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'codigo_producto' => 'required|unique:producto_servicio_d,c_codigo,NULL,id_producto_servicio,id_colegio,'.$id_colegio.'|max:191',
                'tributo_producto'=> 'required|numeric',
                'unidad_producto' => 'required|max:191',
                'unidad_sunat_producto' =>'required|max:191',
                'precio_producto_sin_igv'=> 'required|numeric|min:0',
                'precio_producto_con_igv'=> 'required|numeric|min:0',
            ];
        }

    }
}
