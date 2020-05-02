<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;

class SuperAdmin extends Controller
{
    public function generar_usuario(Request $request){
        $usuario_dni = App\User::where([
            'email' => $request->input('dni'),
            'estado' => 1
        ])->first();
        $name_usuario = '';
        if (!is_null($usuario_dni) && !empty($usuario_dni)) {
            $correlativo = 1;
            $usuarios = DB::table('users')
                ->where('email', 'like', $usuario_dni->email . '-%')
                ->get();
            $correlativos = array();
            $i = 0;
            foreach ($usuarios as $usuario_value) {
                $correlativos[$i] = (int) (substr((stristr($usuario_value->email, "-")), 1));
                $i++;
            }
            if ($i == 0) {
                $name_usuario = $request->input('dni') . '-' . ($correlativo);
            } else {
                $correlativo = max($correlativos) + 1;
                $name_usuario = $request->input('dni') . '-' . $correlativo;
            }
        } else {
            $name_usuario = $request->input('dni');
        }
        $datos = array(
            'usuario_generado' => $name_usuario
        );
        return response()->json($datos);
    }
}
