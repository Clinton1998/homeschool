<?php

namespace App\Http\Middleware;

use Closure;
use App\Colegio_m;
use Auth;
class VerificarPermisoFacturacion
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
        $colegio = Colegio_m::where([
          'id_superadministrador' => Auth::user()->id,
          'estado' => 1
        ])->first();
        if(is_null($colegio) || empty($colegio)){
          return redirect('/home');
        }
        if($colegio->c_bloque_fact!='VISIB'){
          return redirect('/home');
        }
        return $next($request);
    }
}
