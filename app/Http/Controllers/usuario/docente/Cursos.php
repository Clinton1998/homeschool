<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
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

        $secciones = DB::table('seccion_d')
            ->join('docente_seccion_p','seccion_d.id_seccion','=','docente_seccion_p.id_seccion')
            ->join('docente_d','docente_seccion_p.id_docente','=','docente_d.id_docente')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select('seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_d.estado' => 1, 'grado_m.estado' => 1, 'docente_d.estado' => 1, 'docente_seccion_p.id_docente' => $docente->id_docente])
        ->first();

        $cursos = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->select('categoria_d.id_categoria','categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso', 'seccion_d.id_seccion')
            ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1])
            ->orderBy('categoria_d.c_nombre','ASC')
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
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.id_seccion' => $secciones->id_seccion])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        $anuncios_seccion_all = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->select ('anuncio_d.*')
            ->where(['seccion_d.id_seccion' => $secciones->id_seccion])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return view('docente.cursos', compact('secciones','cursos','comunicados','comunicados_all','anuncios_seccion','anuncios_seccion_all'));
    }

    public function curso($id_curso){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        //Datos del curso
        $curso = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->select('categoria_d.id_categoria','categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso', 'seccion_d.id_seccion')
            ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        //Datos de la sección
        $seccion = DB::table('seccion_d')
            ->join('docente_seccion_p','seccion_d.id_seccion','=','docente_seccion_p.id_seccion')
            ->join('docente_d','docente_seccion_p.id_docente','=','docente_d.id_docente')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select('seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_d.estado' => 1, 'grado_m.estado' => 1, 'docente_d.estado' => 1, 'docente_seccion_p.id_docente' => $docente->id_docente])
        ->first();

        //Sección categoría
        $id_sc = DB::table('seccion_categoria_p')
            ->select('seccion_categoria_p.*')
            ->where(['seccion_categoria_p.estado' => 1, 'seccion_categoria_p.id_seccion' => $seccion->id_seccion, 'seccion_categoria_p.id_categoria' => $id_curso])
        ->first();

        //Módulos del curso (seccion - categoria)
        $modulos = DB::table('modulo_d')
            ->select('modulo_d.*')
            ->where(['modulo_d.id_seccion_categoria' => $id_sc->id_seccion_categoria, 'modulo_d.estado' => 1])
            ->orderBy('modulo_d.id_modulo', 'ASC')
        ->get();

        //Anuncios
        $anuncios_seccion = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.id_seccion' => $seccion->id_seccion])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Anuncios
        $anuncios_curso = DB::table('anuncio_d')
            ->join('seccion_categoria_p','anuncio_d.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_categoria_p.id_seccion' => $seccion->id_seccion, 'seccion_categoria_p.id_categoria' => $id_curso])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Archivos
        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.estado' => 1])
            ->orderBy('archivo_d.id_archivo','ASC')
        ->get();

        //Docente del curso


        //Alumnos de curso - sección (seccion-categoria)
        $alumnosseccion = DB::table('alumno_d')
            ->select('alumno_d.*')
            ->where(['alumno_d.id_seccion' => $seccion->id_seccion])
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

        /* $COD = substr($Request->c_para,0,1);

         if ($COD == '1') {
            $anuncio->id_seccion = substr($Request->c_para,1);
            $anuncio->id_seccion_categoria = substr($Request->c_para,1);
            $anuncio->c_titulo = '1'.$Request->c_titulo;
        }

        if ($COD == '2') {
            $anuncio->id_seccion = substr($Request->c_para,1);
            $anuncio->id_seccion_categoria = substr($Request->c_para,1);
            $anuncio->c_titulo = '2'.$Request->c_titulo;
         } */

        $anuncio->id_seccion = $Request->c_para;
        $anuncio->id_seccion_categoria = $Request->c_para;
        $anuncio->c_titulo = $Request->c_titulo;
        $anuncio->c_url_archivo = $Request->c_url_archivo;
        $anuncio->creador = Auth::user()->id;
        $anuncio->save();

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
}
