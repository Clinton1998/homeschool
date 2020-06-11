<?php

namespace App\Http\Requests\facturacion;

use Illuminate\Foundation\Http\FormRequest;

class CrearPreferencia extends FormRequest
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
            'tipo_documento_preferencia' => 'required|numeric',
            'serie_preferencia' => 'required|numeric',
            'tipo_impresion_preferencia' => 'required|numeric',
            'datos_adicionales_preferencia' => 'required|numeric',
            'modo_emision_preferencia' => 'required|string|size:3'
        ];
    }
}
