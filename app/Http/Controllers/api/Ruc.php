<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Ruc extends Controller
{
    public function buscar(Request $request){
        $ruc = $request->input('ruc');
        $ch = curl_init("http://144.217.215.6/sunat/libre.php?ruc=".$ruc);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
