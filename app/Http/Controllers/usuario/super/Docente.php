<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;

class Docente extends Controller
{
    private $fotos_path;
    public function __construct()
    {
        $this->middleware('auth');
        $this->fotos_path = storage_path('app/public/docente');
    }

    public function index()
    {
        //consultando los docentes del colegio
        $usuario = App\User::findOrFail(Auth::user()->id);
        //consultando el colegio
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        $docentes = App\Docente_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->orderBy('created_at', 'DESC')->get();

        //obtenemos las categorias del colegio
        /*COPY CODIGO DE ANTONI del metodo index de la ruta super/categorias */
        $TMP_categorias = DB::table('seccion_categoria_p')
            ->join('seccion_d', 'seccion_categoria_p.id_seccion', '=', 'seccion_d.id_seccion')
            ->join('categoria_d', 'seccion_categoria_p.id_categoria', '=', 'categoria_d.id_categoria')
            ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
            ->join('colegio_m', 'grado_m.id_colegio', '=', 'colegio_m.id_colegio')
            ->select('categoria_d.c_nombre as nom_categoria', 'categoria_d.*', 'seccion_d.c_nombre as nom_seccion', 'seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*', 'colegio_m.*')
            ->where([
                'categoria_d.id_colegio' => $colegio->id_colegio,
                'grado_m.estado' => 1,
                'seccion_d.estado' => 1,
                'categoria_d.estado' => 1
            ])
            ->orderBy('nom_grado', 'ASC')->orderBy('nom_seccion', 'ASC')->get();

        $TMP = DB::table('seccion_d')
            ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
            ->join('colegio_m', 'grado_m.id_colegio', '=', 'colegio_m.id_colegio')
            ->select('seccion_d.c_nombre as nom_seccion', 'seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
            ->where([
                'grado_m.id_colegio' => $colegio->id_colegio,
                'grado_m.estado' => 1,
                'seccion_d.estado' => 1
            ])
            ->orderBy('grado_m.c_nivel_academico', 'ASC')->orderBy('grado_m.c_nombre', 'ASC')->orderBy('seccion_d.c_nombre', 'ASC')->get();



        return view('docentessuper', compact('docentes', 'TMP_categorias', 'TMP'));
    }

    public function info($id_docente)
    {
        $docente = App\Docente_d::findOrFail($id_docente);
        //a que colegio pertenece el docente
        $colegio = App\Colegio_m::findOrFail($docente->id_colegio);
        //obtenemos el usuario
        $usuario_del_docente = App\User::where('id_docente', '=', $docente->id_docente)->first();

        $TMP = DB::table('seccion_d')
            ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
            ->join('colegio_m', 'grado_m.id_colegio', '=', 'colegio_m.id_colegio')
            ->select('seccion_d.c_nombre as nom_seccion', 'seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
            ->where([
                'grado_m.id_colegio' => $colegio->id_colegio,
                'grado_m.estado' => 1,
                'seccion_d.estado' => 1
            ])
            ->orderBy('grado_m.c_nivel_academico', 'ASC')->orderBy('grado_m.c_nombre', 'ASC')->orderBy('seccion_d.c_nombre', 'ASC')->get();

        //obteniendo cursos del docente
        $pivot_seccion_categoria_docente = DB::table('seccion_categoria_docente_p')
                ->join('seccion_categoria_p','seccion_categoria_docente_p.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
                ->select('seccion_categoria_p.*','seccion_categoria_docente_p.id_seccion_categoria_docente as pivot_3')
                ->where([
                    'seccion_categoria_docente_p.id_docente' => $docente->id_docente
                ])->get();
        $array_cursos = array();

        foreach($pivot_seccion_categoria_docente as $pivot){
            $item = array();
            $temp_curso = App\Categoria_d::where([
                'id_categoria' => $pivot->id_categoria,
                'estado' => 1
            ])->first();

            $temp_seccion = App\Seccion_d::where([
                'id_seccion' => $pivot->id_seccion,
                'estado' =>1
            ])->first();

            if((!is_null($temp_curso) && !empty($temp_curso)) && (!is_null($temp_seccion) && !empty($temp_seccion))){
                $item['pivot'] = $pivot->pivot_3;
                $item['curso'] = $temp_curso;
                $item['seccion'] = $temp_seccion;
                array_push($array_cursos,$item);
            }
        }
        $cursos = collect($array_cursos);
        return view('infodocentesuper', compact('docente', 'usuario_del_docente', 'TMP','cursos'));
    }

    public function agregar(Request $request)
    {
        //tamaño maximo de imagen 256 MB algo imposible pero luego se cambia
        //validamos los datos
        $request->validate([
            'dni' => 'required|string|size:8',
            'apellido' => 'required',
            'nombre' => 'required',
            'nacionalidad' => 'required',
            'sexo' => 'required|string|size:1',
            'fecha_nacimiento' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'fotodocente' => 'image|mimes:jpeg,png,gif|max:256000'
        ]);


        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();


        //registrando al docente
        $docente = new App\Docente_d;
        $docente->id_colegio = $colegio->id_colegio;
        $docente->c_dni = $request->input('dni');
        $docente->c_nombre = $request->input('apellido') . " " . $request->input('nombre');
        $docente->c_nacionalidad = $request->input('nacionalidad');
        $docente->c_sexo = $request->input('sexo');
        $docente->c_especialidad = $request->input('especialidad');
        $docente->t_fecha_nacimiento = $request->input('fecha_nacimiento');
        $docente->c_correo = $request->input('correo');
        $docente->c_telefono = $request->input('telefono');
        $docente->c_direccion = $request->input('direccion');
        $docente->creador = $usuario->id;
        $docente->save();

        //asignando secciones al docente
        $secciones = $request->input('optsecciones');
        if (!is_null($secciones) && !empty($secciones)) {
            for ($i = 0; $i < count($secciones); $i++) {
                //verificamos si ya existe esa seccion en el docente
                $pivot = DB::table('docente_seccion_p')->where([
                    'id_docente' => $docente->id_docente,
                    'id_seccion' => $secciones[$i]
                ])->first();

                if (is_null($pivot) || empty($pivot)) {
                    DB::table('docente_seccion_p')->insert([
                        ['id_docente' => $docente->id_docente, 'id_seccion' => $secciones[$i], 'creador' => $usuario->id]
                    ]);

                    //asignacion de cursos
                    $cursos = $request->input('optcursos' . $secciones[$i]);
                    if (!is_null($cursos) && !empty($cursos)) {
                        for ($j = 0; $j < count($cursos); $j++) {

                            //obteniendo id_seccion_categoria
                            $pivot_seccion_categoria = DB::table('seccion_categoria_p')->where([
                                'id_seccion' => $secciones[$i],
                                'id_categoria' => $cursos[$j]
                            ])->first();

                            if (!is_null($pivot_seccion_categoria) && !empty($pivot_seccion_categoria)) {
                                //verificando si ya existe la relacion
                                $pivot_seccion_categoria_docente = DB::table('seccion_categoria_docente_p')->where([
                                    'id_seccion_categoria' => $pivot_seccion_categoria->id_seccion_categoria,
                                    'id_docente' => $docente->id_docente
                                ])->first();

                                if (is_null($pivot_seccion_categoria_docente) || empty($pivot_seccion_categoria_docente)) {
                                    //registrando la relacion
                                    DB::table('seccion_categoria_docente_p')->insert([
                                        ['id_seccion_categoria' => $pivot_seccion_categoria->id_seccion_categoria, 'id_docente' => $docente->id_docente, 'creador' => $usuario->id]
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        //asignamos su foto de docente
        $foto = $request->file('fotodocente');
        if (!is_null($foto) && !empty($foto)) {
            if (!is_dir($this->fotos_path)) {
                mkdir($this->fotos_path, 0777);
            }
            $name = sha1(date('YmdHis'));
            $save_name = $name . '.' . $foto->getClientOriginalExtension();
            $resize_name = $name . '.' . $foto->getClientOriginalExtension();
            Image::make($foto)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->fotos_path . '/' . $resize_name);
            $foto->move($this->fotos_path, $save_name);

            //actualizamos foto del docente
            $docente->c_foto = $resize_name;
            $docente->save();
        }
        //creamos un usuario con ese docente
        //password por defecto 12345678
        $usuario_dni = App\User::where([
            'email' => $request->input('dni'),
            'estado' => 1
        ])->first();
        $name_usuario = '';
        if (!is_null($usuario_dni) && !empty($usuario_dni)) {
            $correlativo = 1;
            $usuarios = DB::table('users')
                ->where('email', 'like', $usuario_dni->email . '-%')
                ->get();

            $correlativos = array();
            $i = 0;
            foreach ($usuarios as $usuario_value) {
                $correlativos[$i] = (int) (substr((stristr($usuario_value->email, "-")), 1));
                $i++;
            }
            if ($i == 0) {
                $name_usuario = $request->input('dni') . '-' . ($correlativo);
            } else {
                $correlativo = max($correlativos) + 1;
                $name_usuario = $request->input('dni') . '-' . $correlativo;
            }
        } else {
            $name_usuario = $request->input('dni');
        }
        $newusuario = new App\User;
        $newusuario->email = $name_usuario;
        $newusuario->password = bcrypt('12345678');
        $newusuario->id_docente = $docente->id_docente;
        $newusuario->creador = $usuario->id;
        $newusuario->save();

        //registramos herramientas por defecto al usuario
        DB::table('herramienta_d')->insert([
          ['id_usuario' => $newusuario->id,'c_nombre' => 'Google Drive','c_logo_link' => url('/assets/images/tools/google-drive.png'),'c_link' => 'https://drive.google.com/','b_mantenimiento' => 0,'creador' => $newusuario->id],
          ['id_usuario' => $newusuario->id,'c_nombre' => 'YouTube Innova','c_logo_link' => url('/assets/images/tools/youtube.png'),'c_link' => 'https://www.youtube.com/channel/UCtogoQsfAGBpGcn7BClcIYg','b_mantenimiento' => 0,'creador' => $newusuario->id]
        ]);

        return redirect('super/docentes');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8',
            'nombre' => 'required',
            'nacionalidad' => 'required',
            'sexo' => 'required|string|size:1',
            'fecha_nacimiento' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required'
        ]);
        //verificamos que el colegio pertenesca al superadministrador
        $usuario = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();
        //si todo esta bien actualizamos el docente
        $docente = App\Docente_d::where([
            'id_docente' => $request->input('id_docente'),
            'id_colegio' => $colegio->id_colegio
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            //actualizamos al docente
            $dni_temp = $docente->c_dni;
            $docente->c_dni = $request->input('dni');
            $docente->c_nombre = $request->input('nombre');
            $docente->c_nacionalidad = $request->input('nacionalidad');
            $docente->c_especialidad = $request->input('especialidad');
            $docente->c_sexo = $request->input('sexo');
            $docente->t_fecha_nacimiento = $request->input('fecha_nacimiento');
            $docente->c_correo = $request->input('correo');
            $docente->c_telefono = $request->input('telefono');
            $docente->c_direccion = $request->input('direccion');
            $docente->modificador = $usuario->id;
            $docente->save();

            if($dni_temp!=$docente->c_dni){
              //actualizamos el usuario de ese docente
              $usuario_dni = App\User::where([
                  'email' => $docente->c_dni,
                  'estado' => 1
              ])->first();
              $name_usuario = '';
              if (!is_null($usuario_dni) && !empty($usuario_dni)) {
                  $correlativo = 1;
                  $usuarios = DB::table('users')
                      ->where('email', 'like', $usuario_dni->email . '-%')
                      ->get();

                  $correlativos = array();
                  $i = 0;
                  foreach ($usuarios as $usuario_value) {
                      $correlativos[$i] = (int) (substr((stristr($usuario_value->email, "-")), 1));
                      $i++;
                  }
                  if ($i == 0) {
                      $name_usuario = $docente->c_dni . '-' . ($correlativo);
                  } else {
                      $correlativo = max($correlativos) + 1;
                      $name_usuario = $docente->c_dni . '-' . $correlativo;
                  }
              } else {
                  $name_usuario = $docente->c_dni;
              }
              $usuario_actual = $docente->usuario;
              $usuario_actual->email = $name_usuario;
              $usuario_actual->password = bcrypt('12345678');
              $usuario_actual->save();
            }
        }
        return redirect('super/docente/' . $request->input('id_docente'));
    }
    public function quitar_seccion(Request $request)
    {
        DB::table('docente_seccion_p')->where([
            'id_seccion' => $request->input('id_seccion'),
            'id_docente' => $request->input('id_docente')
        ])->delete();

        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }

    public function agregar_seccion(Request $request)
    {
        $docente = App\Docente_d::findOrFail($request->input('id_docente'));
        $secciones = $request->input('optsecciones');
        if (!is_null($secciones) && !empty($secciones)) {
            for ($i = 0; $i < count($secciones); $i++) {
                //verificamos si ya existe esa seccion en el docente
                $pivot = DB::table('docente_seccion_p')->where([
                    'id_docente' => $docente->id_docente,
                    'id_seccion' => $secciones[$i]
                ])->first();

                if (is_null($pivot) || empty($pivot)) {
                    DB::table('docente_seccion_p')->insert([
                        ['id_docente' => $docente->id_docente, 'id_seccion' => $secciones[$i], 'creador' => Auth::user()->id]
                    ]);
                }
            }
        }

        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }

    public function quitar_categoria(Request $request)
    {
        DB::table('seccion_categoria_docente_p')->where([
            'id_seccion_categoria_docente' => $request->input('id_pivot'),
            'id_docente' => $request->input('id_docente')
        ])->delete();

        $datos = array(
            'correcto' => TRUE
        );
        return response()->json($datos);
    }

    public function agregar_categoria(Request $request)
    {
        $docente = App\Docente_d::findOrFail($request->input('id_docente'));
        $categorias = $request->input('optcategorias');
        $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
        if(!is_null($categorias) && !empty($categorias)){
            for($i = 0; $i<count($categorias); $i++){
                //verificamos si existe la categoria en esa seccion
                $pivot_seccion_categoria = DB::table('seccion_categoria_p')->where([
                    'id_seccion' => $seccion->id_seccion,
                    'id_categoria'=> $categorias[$i]
                ])->first();

                if(!is_null($pivot_seccion_categoria) && !empty($pivot_seccion_categoria)){
                    //verificando si ya existe la relacion
                    $pivot_seccion_categoria_docente = DB::table('seccion_categoria_docente_p')->where([
                        'id_seccion_categoria' => $pivot_seccion_categoria->id_seccion_categoria,
                        'id_docente' => $docente->id_docente
                    ])->first();

                    if (is_null($pivot_seccion_categoria_docente) || empty($pivot_seccion_categoria_docente)) {
                        //registrando la relacion
                        DB::table('seccion_categoria_docente_p')->insert([
                            ['id_seccion_categoria' => $pivot_seccion_categoria->id_seccion_categoria, 'id_docente' => $docente->id_docente, 'creador' => Auth::user()->id]
                        ]);
                    }
                }
            }
        }
        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }

    public function cambiar_foto(Request $request)
    {
        //tamaño maximo de imagen 256 MB algo imposible pero luego se cambia
        $request->validate([
            'fotodocente' => 'required|image|mimes:jpeg,png,gif|max:256000'
        ]);
        //verificamos el usuario
        $usuario = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio del superadministrador
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        //consultamos el docente
        $docente = App\Docente_d::where([
            'id_docente' => $request->input('fotoid_docente'),
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            $foto = $request->file('fotodocente');
            if (!is_dir($this->fotos_path)) {
                mkdir($this->fotos_path, 0777);
            }
            $name = sha1(date('YmdHis'));
            $save_name = $name . '.' . $foto->getClientOriginalExtension();
            $resize_name = $name . '.' . $foto->getClientOriginalExtension();
            Image::make($foto)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->fotos_path . '/' . $resize_name);
            $foto->move($this->fotos_path, $save_name);

            //actualizamos el logo del colegio
            $docente->c_foto = $resize_name;
            $docente->modificador = $usuario->id;
            $docente->save();
        }
        return redirect('super/docente/' . $request->input('fotoid_docente'));
    }

    public function foto($fileName)
    {
        $content = Storage::get('public/docente/' . $fileName);
        //proceso para obtener la extension
        $ext = pathinfo($fileName)['extension'];
        $mime = '';
        if ($ext == 'jpg' || $ext == 'jpeg') {
            $mime = 'image/jpeg';
        } else if ($ext == 'gif') {
            $mime = 'image/gif';
        } else if ($ext == 'png') {
            $mime = 'image/png';
        }
        return response($content)
            ->header('Content-Type', $mime);
    }

    public function cambiar_contrasena(Request $request)
    {
        $request->validate([
            'contrasena' => 'required|string|min:6',
            'repite_contrasena' => 'required|string|min:6|same:contrasena',
        ]);
        //consultando al docente
        $docente = App\Docente_d::findOrFail($request->input('id_docente'));
        //si todo es correcto entonces cambiamos la contrasenia
        $usuario = App\User::where([
            'id_docente' => $docente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($usuario) && !empty($usuario)) {
            $usuario->password = bcrypt($request->input('repite_contrasena'));
            $usuario->modificador = Auth::user()->id;
            $usuario->save();
        }
        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }

    public function eliminar(Request $request)
    {
        //verificamos el super administrador
        $usuario = App\User::findOrFail(Auth::user()->id);

        //consultamos el colegio
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        //verificamos si el docente existe
        $docente = App\Docente_d::where([
            'id_docente' => $request->input('id_docente'),
            'id_colegio' => $colegio->id_colegio
        ])->first();
        $docente->estado = 0;
        $docente->save();

        //eliminamos el usuario del docente
        if (!is_null($docente) && !empty($docente)) {
            (App\User::where('id_docente', '=', $docente->id_docente)->first())->delete();
        }

        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }
}
