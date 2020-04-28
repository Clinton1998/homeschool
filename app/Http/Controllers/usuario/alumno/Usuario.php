<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Usuario extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cambiar_contrasena(Request $request)
    {
        $request->validate([
            'nueva_contrasena' => 'required|string|min:6',
            'repite_nueva_contrasena' => 'required|string|min:6|same:nueva_contrasena',
        ]);

        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);;
        $usuarioAlumno->password = bcrypt($request->input('repite_nueva_contrasena'));
        $usuarioAlumno->modificador = Auth::user()->id;
        $usuarioAlumno->save();
            
        return redirect('home');
    }
    public function index()
    {
        return view('alumno.cambiarcontrasena');
    }
}
