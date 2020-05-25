<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
