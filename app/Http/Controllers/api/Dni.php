<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dni extends Controller
{
    public function buscar(Request $request){
        $data = array(
            'dni' => $request->input('dni')
        );
        //url de la direccion a consumir
        $ch = curl_init("https://dniruc.apisperu.com/api/v1/dni/".$data['dni']."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //obtenemos la respuesta
        $response = curl_exec($ch);
        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);
        return $response;
    }
}
