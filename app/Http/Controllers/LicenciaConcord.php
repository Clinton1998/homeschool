<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Colegio_m;

class LicenciaConcord extends Controller
{
    public function actualizar_clave(Request $request){
      //obtenemos el colegio con ese token
      $colegio = Colegio_m::where([
        'c_token' => trim($request->input('token')),
        'estado' => 1
      ])->first();
      if(!is_null($colegio) & !empty($colegio)){
        //procedemos a actualizar la clave
        $colegio->c_clave = trim($request->input('clave'));
        $colegio->save();
        return response()->json(['correcto' => TRUE,'colegio' => $colegio]) ;
      }
      return response()->json(['correcto' => FALSE]);
    }
}
