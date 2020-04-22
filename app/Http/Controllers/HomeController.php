<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0){
            //se trata de un superadministrador del colegio
            return view('homesuperadministrador');
        }else if(!is_null(Auth::user()->id_docente)){
            return view('homedocente');
        }else if(!is_null(Auth::user()->id_alumno)){
            return view('homealumno');
        }else{
            //es un usuario root de Innova Sistemas  Integrales
            return view('homeroot');
        }
    }
}
