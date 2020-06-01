<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dni extends Controller
{
    public function buscar(Request $request)
    {
        $dni = $request->input('dni');
        $ch = curl_init("http://bytesoluciones.com/apidnix/apidni.php?dni=".$dni);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
