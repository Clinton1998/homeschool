<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
class Usuario extends Controller
{
    public function cambiar_contrasena(Request $request){
        $request->validate([
            'contrasenia' => 'required|string|min:6',
            'repite_contrasenia' => 'required|string|min:6|same:contrasenia',
        ]);
        //si todo es correcto entonces cambiamos la contrasenia
        $usuario = App\User::findOrFail(Auth::user()->id);
        $usuario->password = bcrypt($request->input('repite_contrasenia'));
        $usuario->modificador = Auth::user()->id;
        $usuario->save();
        return redirect('super/colegio');
    }
}
