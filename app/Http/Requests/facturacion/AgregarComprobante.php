<?php

namespace App\Http\Requests\facturacion;

use Illuminate\Foundation\Http\FormRequest;

class AgregarComprobante extends FormRequest
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
        if($this->is_for_alumno==1){
            return [
                'fecha' => 'required|date',
                'id_serie' => 'required|integer',
                'numero' =>'required|integer',
                'id_tipo_documento' => 'required|integer',
                'id_moneda' => 'required|integer',
                'id_alumno' => 'required|integer',
                'dni_alumno'=> 'required|numeric|digits:8',
                'nombre_alumno' => 'required',
                'numero_documento_identidad' => 'required|numeric|digits_between:8,11',
                'nombre_receptor' => 'required',
                'direccion_receptor' => 'required',
                'observaciones' => 'required',
                'id_tipo_impresion' => 'required|integer',
                'total_operacion_gravada' => 'required|numeric',
                'total_operacion_exonerada' => 'required|numeric',
                'total_operacion_inafecta' => 'required|numeric',
                'total_operacion_gratuita' => 'required|numeric',
                'total_descuento' => 'required|numeric',
                'total_igv' => 'required|numeric',
                'total' =>'required|numeric',
                'items' => 'required|array|min:1'
            ];
        }else{
            return [
                'fecha' => 'required|date',
                'id_serie' => 'required|integer',
                'numero' =>'required|integer',
                'id_tipo_documento' => 'required|integer',
                'id_moneda' => 'required|integer',
                'numero_documento_identidad' => 'required|numeric|digits_between:8,11',
                'nombre_receptor' => 'required',
                'direccion_receptor' => 'required',
                'observaciones' => 'required',
                'id_tipo_impresion' => 'required|integer',
                'total_operacion_gravada' => 'required|numeric',
                'total_operacion_exonerada' => 'required|numeric',
                'total_operacion_inafecta' => 'required|numeric',
                'total_operacion_gratuita' => 'required|numeric',
                'total_descuento' => 'required|numeric',
                'total_igv' => 'required|numeric',
                'total' =>'required|numeric',
                'items' => 'required|array|min:1'
            ];
        }
    }
}
