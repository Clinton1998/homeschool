<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'tipo_producto'=> 'required|min:8|max:8',
            'nombre_producto' => 'required|max:191',
            'codigo_producto' => 'required|max:191',
            'tributo_producto'=> 'required|numeric',
            'unidad_producto' => 'required|max:191',
            'unidad_sunat_producto' =>'required|max:191',
            'precio_producto_sin_igv'=> 'required|numeric|min:0',
            'precio_producto_con_igv'=> 'required|numeric|min:0',
        ];
    }
}
