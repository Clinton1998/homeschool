<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class Pago extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function verificar(Request $request)
    {
        $permitido = App\Permitido_m::where([
            'c_ruc' => $request->input('ruc'),
            'c_estado' => 'ACTI'
        ])->first();

        if (!is_null($permitido) && !empty($permitido)) {
            $datos = array(
                'permitido' => TRUE
            );
            return response()->json($datos);
        }
        
        $datos = array(
            'permitido' => FALSE
        );
        return response()->json($datos);
    }
}
