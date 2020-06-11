<?php

namespace App\Http\Requests\facturacion;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPreferencia extends FormRequest
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
            'id_preferencia' => 'required|numeric',
            'serie' => 'required|numeric',
            'tipo_impresion' => 'required|numeric',
            'datos_adicionales' => 'required|numeric',
            'modo_emision' => 'required|string|size:3'
        ];
    }
}
