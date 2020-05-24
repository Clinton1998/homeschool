<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class VerificarSuperAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //verificar que no es un superadministrador de un colegio
        if(!(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0)){
            return redirect('home');
        }
        return $next($request);
    }
}
