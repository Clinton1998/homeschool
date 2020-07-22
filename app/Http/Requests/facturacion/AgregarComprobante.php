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
        /*
            total_operacion_gravada: $('#spnTotalOpGravada').text(),
        total_operacion_exonerada: $('#spnTotalOpExonerada').text(),
        total_operacion_inafecta: $('#spnTotalOpInafecta').text(),
        total_operacion_gratuita: $('#spnTotalOpGratuita').text(),
        total_descuento: $('#spnDescuentoComprobante').text(),
        total_igv: $('#spnTotalIgv').text(),
        total: $('#spnTotalConDescuentoComprobante').text(),
        items: []
        */
        return [
            'fecha' => 'required|date',
            'id_serie' => 'required|integer',
            'id_tipo_documento' => 'required|integer',
            'id_moneda' => 'required|integer',
            'nombre_receptor' => 'required',
            'numero_documento_identidad' => 'required|numeric|digits_between:8,11',
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
            'items' => 'required|array'
        ];
    }
}
