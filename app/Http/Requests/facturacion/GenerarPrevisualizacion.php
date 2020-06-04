<?php

namespace App\Http\Requests\facturacion;

use Illuminate\Foundation\Http\FormRequest;

class GenerarPrevisualizacion extends FormRequest
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
            'tipo_documento' => 'required',
            'tipo_impresion' => 'required'
        ];
    }
}
