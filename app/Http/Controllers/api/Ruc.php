<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Ruc extends Controller
{
    public function buscar(Request $request){
        $data = array(
            'ruc' => $request->input('ruc')
        );
        $ch = curl_init("https://dniruc.apisperu.com/api/v1/ruc/" . $data['ruc'] . "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
