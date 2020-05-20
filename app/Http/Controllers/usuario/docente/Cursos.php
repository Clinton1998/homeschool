<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;

class Cursos extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $cursos_del_docente = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->join('seccion_categoria_docente_p','seccion_categoria_p.id_seccion_categoria','=','seccion_categoria_docente_p.id_seccion_categoria')
            ->select('seccion_categoria_p.id_seccion_categoria',
                    'categoria_d.id_categoria', 'categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso',
                    'seccion_d.id_seccion', 'seccion_d.c_nombre as nom_seccion',
                    'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_categoria_docente_p.id_docente' => $docente->id_docente,
                'categoria_d.estado' => 1,
                'seccion_d.estado' => 1,
                'grado_m.estado' => 1,
                'seccion_categoria_p.estado' => 1,
                'seccion_categoria_docente_p.estado' => 1])
            ->orderBy('nom_nivel')
            ->orderBy('nom_grado')
            ->orderBy('nom_curso')
        ->get();

        $comunicados = DB::table('comunicado_d')
            ->select ('comunicado_d.*')
            ->where(['comunicado_d.estado' => 1, 'comunicado_d.id_colegio' => $docente->id_colegio])
            ->orderBy('comunicado_d.created_at', 'DESC')
        ->get();

        $comunicados_all = DB::table('comunicado_d')
            ->select ('comunicado_d.*')
            ->where(['comunicado_d.id_colegio' => $docente->id_colegio])
            ->orderBy('comunicado_d.created_at', 'DESC')
        ->get();

        $anuncios_seccion = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select ('anuncio_d.*', 'seccion_d.c_nombre  as nom_seccion', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.estado' => 1,'grado_m.estado' => 1,'anuncio_d.creador' => Auth::user()->id])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        $anuncios_seccion_all = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select ('anuncio_d.*', 'seccion_d.c_nombre  as nom_seccion', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.estado' => 1,'grado_m.estado' => 1,'anuncio_d.creador' => Auth::user()->id])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return view('docente.cursos', compact('cursos_del_docente', 'comunicados', 'comunicados_all', 'anuncios_seccion', 'anuncios_seccion_all'));
    }

    public function curso($id_curso){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $curso = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->join('seccion_categoria_docente_p','seccion_categoria_p.id_seccion_categoria','=','seccion_categoria_docente_p.id_seccion_categoria')
            ->join('docente_d','seccion_categoria_docente_p.id_docente','=','docente_d.id_docente')
            ->select('seccion_categoria_p.id_seccion_categoria',
                    'categoria_d.id_categoria', 'categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso',
                    'seccion_d.id_seccion', 'seccion_d.c_nombre as nom_seccion',
                    'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_categoria_p.id_seccion_categoria' => $id_curso, 'seccion_categoria_docente_p.id_docente' => $docente->id_docente,
            'categoria_d.estado' => 1,
            'seccion_d.estado' => 1,
            'grado_m.estado' => 1,
            'seccion_categoria_p.estado' => 1,
            'seccion_categoria_docente_p.estado' => 1])
        ->first();

        //Módulos del curso (seccion - categoria)
        $modulos = DB::table('modulo_d')
            ->select('modulo_d.*')
            ->where(['modulo_d.id_seccion_categoria' => $curso->id_seccion_categoria, 'modulo_d.estado' => 1])
            ->orderBy('modulo_d.id_modulo', 'ASC')
        ->get();

        //Anuncios para sección
        $anuncios_seccion = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.id_seccion' => $curso->id_seccion])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Anuncios para curso
        $anuncios_curso = DB::table('anuncio_d')
            ->join('seccion_categoria_p','anuncio_d.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_categoria_p.id_seccion_categoria' => $curso->id_seccion_categoria])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Archivos
        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.estado' => 1])
            ->orderBy('archivo_d.id_archivo','ASC')
        ->get();

        //Alumnos de curso - sección (seccion-categoria)
        $alumnosseccion = DB::table('alumno_d')
            ->select('alumno_d.*')
            ->where(['alumno_d.id_seccion' => $curso->id_seccion, 'alumno_d.estado' => 1])
            ->orderBy('alumno_d.c_nombre', 'ASC')
        ->get();

        return view('docente.curso', compact('curso', 'id_sc', 'modulos', 'anuncios_seccion', 'anuncios_curso', 'archivos', 'alumnosseccion'));
    }

    public function crear_modulo(Request $Request){
        $modulo = new App\Modulo_d;
        $modulo->id_seccion_categoria = $Request->id_seccion_categoria;
        $modulo->c_nombre = $Request->c_nombre;
        $modulo->creador = Auth::user()->id;
        $modulo->save();

        $modulos = DB::table('modulo_d')
        ->select('modulo_d.*')
        ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function actualizar_modulo(Request $Request){
        $modulo = App\Modulo_d::findOrFail($Request->id_modulo);
        $modulo->c_nombre = $Request->c_nombre;
        $modulo->modificador = Auth::user()->id;
        $modulo->save();

        $modulos = DB::table('modulo_d')
        ->select('modulo_d.*')
        ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function eliminar_modulo(Request $Request){
        $modulo = App\Modulo_d::findOrFail($Request->id_modulo);
        $modulo->estado = 0;
        $modulo->modificador = Auth::user()->id;
        $modulo->save();

        Storage::deleteDirectory('archivos/'. $Request->id_modulo);

        $modulos = DB::table('modulo_d')
            ->select('modulo_d.*')
            ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function agregar_archivo(Request $Request){
        $archivo = new App\Archivo_d;
        $archivo->id_modulo = $Request->input('id_m_key');
        $archivo->c_nombre = $Request->input('nombre_archivo');

        $TMP = $Request->file('el_archivo');

        if (!is_null($TMP) && !empty($TMP)) {
            $nombre = $TMP->getClientOriginalName();
            $TMP->storeAs('archivos/'.$Request->input('id_m_key').'/', $nombre);
            $archivo->c_url = $nombre;
        }
        
        $archivo->c_link = $Request->input('url_archivo');
        $archivo->creador = Auth::user()->id;
        $archivo->save();

        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.id_modulo' => $Request->id_modulo, 'archivo_d.estado' => 1])
        ->get();

        return  response()->json($archivos);
    }

    public function eliminar_archivo(Request $Request){

        $archivo = App\Archivo_d::where(['id_archivo' => $Request->id_archivo])->first();
        Storage::delete('archivos/'. $Request->id_modulo .'/'. $archivo->c_url);
        DB::table('archivo_d')->where(['id_archivo' => $Request->id_archivo])->delete();

        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.id_modulo' => $Request->id_modulo, 'archivo_d.estado' => 1])
        ->get();

        return  response()->json($archivos);
    }

    public function descargar_archivo($id_archivo){
        $archivo = App\Archivo_d::findOrFail($id_archivo);
        return Storage::download('archivos/' . $archivo->id_modulo . '/' . $archivo->c_url);
    }

    public function crear_anuncio(Request $Request){

        $anuncio = new App\Anuncio_d;

        $COD = $Request->c_para;

        if ($COD == '1') {
            $anuncio->id_seccion = -1;
            $anuncio->id_seccion_categoria = $Request->isc;
        } else {
            $anuncio->id_seccion = $Request->is;
            $anuncio->id_seccion_categoria = -1;
        }

        $anuncio->c_titulo = $Request->c_titulo;
        $anuncio->c_url_archivo = $Request->c_url_archivo;
        $anuncio->creador = Auth::user()->id;
        $anuncio->save();
        
        $alumnos_asignados = App\Alumno_d::where(['alumno_d.estado' => 1, 'alumno_d.id_seccion' => $Request->is])->get();

        $id_usuarios = array();
        $i = 0;
        foreach ($alumnos_asignados as $alumno) {
            $id_usuarios[$i] = $alumno->usuario->id;
            $i++;
        }
        
        $usuarios_a_notificar = App\User::whereIn('id', $id_usuarios)->get();
        \Notification::send($usuarios_a_notificar, new NuevaTareaParaAlumnoNotification(array(
            'titulo' => $anuncio->c_titulo,
            'mensaje' => $anuncio->c_url_archivo,
            'url' => '/alumno/cursos/',
            'tipo' => 'anuncio',
            'anuncio'=> $anuncio
        )));

        $anuncios = DB::table('anuncio_d')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return response()->json($anuncios);
    }

    public function eliminar_anuncio(Request $Request){
        $anuncio = App\Anuncio_d::findOrFail($Request->id_anuncio);
        $anuncio->estado = 0;
        $anuncio->modificador = Auth::user()->id;
        $anuncio->save();

        $anuncios = DB::table('anuncio_d')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return response()->json($anuncios);
    }

    public function cursos_de_secciones(Request $request){
        $secciones = $request->input('secciones');

        $respuesta = array();

        for($i=0; $i<count($secciones); $i++){
            $seccion = App\Seccion_d::findOrFail($secciones[$i]['value']);
            $seccion->grado;
            $seccion->categorias = $seccion->categorias()->where('categoria_d.estado','=',1)->get();
            array_push($respuesta,$seccion);
        }
        return response()->json($respuesta);
    }
}
