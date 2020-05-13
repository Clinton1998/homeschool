<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarios = '';
        if (is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root == 0) {
            //superadministrador del colegio
            $colegio = App\Colegio_m::where([
                'id_superadministrador' => Auth::user()->id
            ])->first();

            $usuarios_en_superadministrador = array();
            foreach ($colegio->docentes()->where('docente_d.estado', '=', 1)->get() as $docente) {
                $userDocente = App\User::where([
                    'id_docente' => $docente->id_docente
                ])->first();
                
                $usuarios_en_superadministrador[] = $userDocente;
            }
            foreach ($colegio->grados()->where('grado_m.estado', '=', 1)->get() as $grado) {
                foreach ($grado->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                        $userAlumno = App\User::where([
                            'id_alumno' => $alumno->id_alumno
                        ])->first();
                        $usuarios_en_superadministrador[] = $userAlumno;
                    }
                }
            }
            $usuarios = collect($usuarios_en_superadministrador);
        } else if (!is_null(Auth::user()->id_docente)) {
            $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
            $userSuperAdmin = App\User::findOrFail($docente->colegio->id_superadministrador);
            
            $usuarios_en_docente = array($userSuperAdmin);

            $colegas = App\Docente_d::where([
                ['id_colegio', '=', $docente->colegio->id_colegio],
                ['estado', '=', 1],
                ['id_docente', '<>', $docente->id_docente]
            ])->get();

            foreach ($colegas as $colega) {
                $userColega = App\User::where([
                    'id_docente' => $colega->id_docente
                ])->first();
                $usuarios_en_docente[] = $userColega;
            }

            foreach ($docente->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                    $userAlumno = App\User::where([
                        'id_alumno' => $alumno->id_alumno
                    ])->first();
                    $usuarios_en_docente[] = $userAlumno;
                }
            }
            $usuarios = collect($usuarios_en_docente);
        } else if (!is_null(Auth::user()->id_alumno)) {
            //alumno de una seccion
            $alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
            $colegio = $alumno->seccion->grado->colegio;
            $u_con_conversacion = array();
            $u_sin_conversacion = array();
            $superAdmin = App\User::findOrFail($colegio->id_superadministrador);
            $usuarios_en_alumno = array($superAdmin);

            foreach ($alumno->seccion->docentes()->where('docente_d.estado', '=', 1)->get() as $value_docente) {
                $userDocente = App\User::where([
                    'id_docente' => $value_docente->id_docente
                ])->first();
                $usuarios_en_alumno[] = $userDocente;
            }

            foreach ($alumno->seccion->alumnos()->where([
                ['alumno_d.estado', '=', 1],
                ['id_alumno', '<>', Auth::user()->id_alumno]
            ])->get() as $value_alumno) {
                $userAlumno =  App\User::where([
                    'id_alumno' => $value_alumno->id_alumno
                ])->first();
                $usuarios_en_alumno[]= $userAlumno;
            }
            $usuarios = collect($usuarios_en_alumno);
        }
        return view('chat',compact('usuarios'));
    }
}
