<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
class Usuario extends Controller
{
    public function cambiar_contrasena(Request $request)
    {
        $request->validate([
            'nueva_contrasena' => 'required|string|min:6',
            'repite_nueva_contrasena' => 'required|string|min:6|same:nueva_contrasena',
        ]);

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);;
        $usuarioDocente->password = bcrypt($request->input('repite_nueva_contrasena'));
        $usuarioDocente->modificador = Auth::user()->id;
        $usuarioDocente->save();
            
        return redirect('home');
    }
    public function index(){
        return view('docente.cambiarcontrasena');
    }
}
