<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ubigeo extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }
    public function provincias($departamento){
      $provincias = DB::table('ubigeo_m')->where([
        ['c_departamento','=',$departamento],
        ['c_provincia','<>','00'],
        ['c_distrito','=','00']
      ])->select('c_provincia','c_nombre')->orderBy('c_nombre','ASC')->get();
      return response()->json($provincias);
    }

    public function distritos($departamento,$provincia){
      $distritos = DB::table('ubigeo_m')->where([
        ['c_departamento' ,'=',$departamento],
        ['c_provincia','=',$provincia],
        ['c_distrito','<>','00']
      ])->select('id_ubigeo','c_nombre')->orderBy('c_nombre','ASC')->get();
      return response()->json($distritos);
    }
}
