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

class Alumno extends Controller
{
    private $fotos_path;

    public function __construct()
    {
        $this->middleware('auth');
        $this->fotos_path = storage_path('app/public/alumno');
    }

    public function index()
    {
        $usuario = App\User::findOrFail(Auth::user()->id);

        $colegio = App\Colegio_m::where([
            'id_superadministrador' => $usuario->id
        ])->first();

        //obteniendo los grados del colegio
        $grados = App\Grado_m::where([
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->orderBy('c_nivel_academico', 'ASC')->orderBy('c_nombre', 'ASC')->get();

        //obteniendo los alumnos de ese colegio

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

        return view('alumnossuper', compact('grados', 'TMP'));
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
            'direccion' => 'required',
            'optseccion' => 'required',
            'fotoalumno' => 'image|mimes:jpeg,png,gif|max:256000'
        ]);

        $usuario  = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        //aplicando seccion enviada
        $seccion_enviada = App\Seccion_d::where([
            'id_seccion' => $request->input('optseccion'),
            'estado' => 1
        ])->first();

        $colegio_de_seccion = $seccion_enviada->grado->colegio;
        //verificamos si la seccion pertenece al colegio del superadministrador
        if ($colegio->id_colegio == $colegio_de_seccion->id_colegio) {
            //registramos al alumno
            $alumno = new App\Alumno_d;
            $alumno->id_seccion = $seccion_enviada->id_seccion;
            $alumno->c_dni = $request->input('dni');
            $alumno->c_nombre = $request->input('apellido') . " " . $request->input('nombre');
            $alumno->c_nacionalidad = $request->input('nacionalidad');
            $alumno->c_correo = $request->input('correo_alumno');
            $alumno->c_sexo = $request->input('sexo');
            $alumno->t_fecha_nacimiento = $request->input('fecha_nacimiento');
            $alumno->c_direccion = $request->input('direccion');
            $alumno->c_informacion_adicional = $request->input('adicional');

            $alumno->c_dni_representante1 = $request->input('dni_repre1');
            $alumno->c_nombre_representante1 = $request->input('apellido_repre1') . " " . $request->input('nombre_repre1');
            $alumno->c_nacionalidad_representante1 = $request->input('nacionalidad_repre1');
            $alumno->c_sexo_representante1 = $request->input('sexo_repre1');
            $alumno->c_telefono_representante1 = $request->input('telefono_repre1');
            $alumno->c_correo_representante1 = $request->input('correo_repre1');
            $alumno->c_direccion_representante1 = $request->input('direccion_repre1');
            $alumno->c_vinculo_representante1 = $request->input('vinculo_repre1');

            $alumno->c_dni_representante2 = $request->input('dni_repre2');
            $alumno->c_nombre_representante2 = $request->input('apellido_repre2') . " " . $request->input('nombre_repre2');
            $alumno->c_nacionalidad_representante2 = $request->input('nacionalidad_repre2');
            $alumno->c_sexo_representante2 = $request->input('sexo_repre2');
            $alumno->c_telefono_representante2 = $request->input('telefono_repre2');
            $alumno->c_correo_representante2 = $request->input('correo_repre2');
            $alumno->c_direccion_representante2 = $request->input('direccion_repre2');
            $alumno->c_vinculo_representante2 = $request->input('vinculo_repre2');
            $alumno->creador = $usuario->id;
            $alumno->save();


            //asignamos foto al alumno
            //asignamos su foto de docente
            $foto = $request->file('fotoalumno');
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

                //$foto->move($this->fotos_path, $save_name);

                //actualizamos foto del docente
                $alumno->c_foto = $resize_name;
                $alumno->save();
            }

            //creamos un usuario con ese alumno
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
            $newusuario->id_alumno = $alumno->id_alumno;
            $newusuario->creador = $usuario->id;
            $newusuario->save();
        }

        return redirect('super/alumnos');
    }

    public function foto($fileName)
    {
        $content = Storage::get('public/alumno/' . $fileName);
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

    public function info($id_alumno)
    {
        $alumno = App\Alumno_d::findOrFail($id_alumno);

        //a que colegio pertenece el alumno
        $colegio = $alumno->seccion->grado->colegio;

        //obtenemos los grados del colegio
        $grados = App\Grado_m::where([
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->get();
        //obtenemos el usuario del alumno
        $usuario_del_alumno = App\User::where('id_alumno', '=', $alumno->id_alumno)->first();


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


        return view('infoalumnosuper', compact('alumno', 'grados', 'usuario_del_alumno', 'TMP'));
    }

    public function cambiar_foto(Request $request)
    {
        //tamaño maximo de imagen 256 MB algo imposible pero luego se cambia
        $request->validate([
            'fotoalumno' => 'required|image|mimes:jpeg,png,gif|max:256000'
        ]);
        //verificamos el usuario
        $usuario = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio del superadministrador
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        //consultamos al alumno
        $alumno = App\Alumno_d::where([
            'id_alumno' => $request->input('fotoid_alumno'),
            'estado' => 1
        ])->first();
        //verificamos si el alumno pertenece al colegio del superadministrador
        $colegio_solicitado = $alumno->seccion->grado->colegio;
        if ($colegio_solicitado->id_colegio == $colegio->id_colegio) {
            if (!is_null($alumno) && !empty($alumno)) {
                $foto = $request->file('fotoalumno');
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
                $alumno->c_foto = $resize_name;
                $alumno->modificador = $usuario->id;
                $alumno->save();
            }
        }
        return redirect('super/alumno/' . $request->input('fotoid_alumno'));
    }

    public function cambiar_contrasena(Request $request)
    {
        $request->validate([
            'contrasena' => 'required|string|min:6',
            'repite_contrasena' => 'required|string|min:6|same:contrasena',
        ]);
        //consultando al alumno
        $alumno = App\Alumno_d::findOrFail($request->input('id_alumno'));
        //si todo es correcto entonces cambiamos la contrasenia
        $usuario = App\User::where([
            'id_alumno' => $alumno->id_alumno,
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
    public function actualizar(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8',
            'nombre' => 'required',
            'nacionalidad' => 'required',
            'sexo' => 'required|string|size:1',
            'fecha_nacimiento' => 'required',
            'direccion' => 'required',
            'seccion' => 'required'
        ]);
        //verificamos que el colegio pertenesca al superadministrador
        $usuario = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio del superadministrador
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();
        //obtenemos el colegio
        $seccion_solicitada = App\Seccion_d::where([
            'id_seccion' => $request->input('seccion'),
            'estado' => 1
        ])->first();
        $colegio_solicitado = $seccion_solicitada->grado->colegio;

        if ($colegio_solicitado->id_colegio == $colegio->id_colegio) {
            //si todo esta bien actualizamos al alumno
            $alumno = App\Alumno_d::where([
                'id_alumno' => $request->input('id_alumno'),
                'estado' => 1
            ])->first();

            if (!is_null($alumno) && !empty($alumno)) {
                //actualizamos al docente
                $alumno->id_seccion = $seccion_solicitada->id_seccion;
                $alumno->c_dni = $request->input('dni');
                $alumno->c_nombre = $request->input('nombre');
                $alumno->c_nacionalidad = $request->input('nacionalidad');
                $alumno->c_sexo = $request->input('sexo');
                $alumno->t_fecha_nacimiento = $request->input('fecha_nacimiento');
                $alumno->c_correo = $request->input('correo_alumno');
                $alumno->c_direccion = $request->input('direccion');
                $alumno->c_informacion_adicional = $request->input('direccion');
                $alumno->modificador = $usuario->id;
                $alumno->save();
            }
        }
        return redirect('super/alumno/' . $request->input('id_alumno'));
    }

    public function actualizar_representante(Request $request)
    {

        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();
        //verificamos que el alumno pertenesca al colegio

        $alumno = App\Alumno_d::findOrFail($request->input('id_alumno'));
        $colegio_del_solicitante = $alumno->seccion->grado->colegio;

        if ($colegio->id_colegio = $colegio_del_solicitante->id_colegio) {
            $alumno->c_dni_representante1 = $request->input('dni_repre1');
            $alumno->c_nombre_representante1 = $request->input('nombre_repre1');
            $alumno->c_nacionalidad_representante1 = $request->input('nacionalidad_repre1');
            $alumno->c_sexo_representante1 = $request->input('sexo_repre1');
            $alumno->c_telefono_representante1 = $request->input('telefono_repre1');
            $alumno->c_correo_representante1 = $request->input('correo_repre1');
            $alumno->c_direccion_representante1 = $request->input('direccion_repre1');
            $alumno->c_vinculo_representante1 = $request->input('vinculo_repre1');

            $alumno->c_dni_representante2 = $request->input('dni_repre2');
            $alumno->c_nombre_representante2 = $request->input('nombre_repre2');
            $alumno->c_nacionalidad_representante2 = $request->input('nacionalidad_repre2');
            $alumno->c_sexo_representante2 = $request->input('sexo_repre2');
            $alumno->c_telefono_representante2 = $request->input('telefono_repre2');
            $alumno->c_correo_representante2 = $request->input('correo_repre2');
            $alumno->c_direccion_representante2 = $request->input('direccion_repre2');
            $alumno->c_vinculo_representante2 = $request->input('vinculo_repre2');
            $alumno->modificador = $usuario->id;
            $alumno->save();
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

        //verificamos que el alumno pertenesca al colegio del superadministrador
        $alumno = App\Alumno_d::where([
            'id_alumno' => $request->input('id_alumno'),
            'estado' => 1
        ])->first();

        $colegio_solicitante = $alumno->seccion->grado->colegio;

        if ($colegio->id_colegio == $colegio_solicitante->id_colegio) {
            if (!is_null($alumno) && !empty($alumno)) {
                $alumno->estado = 0;
                $alumno->save();
                //eliminamos el usuario del docente
                (App\User::where('id_alumno', '=', $alumno->id_alumno)->first())->delete();
            }
        }

        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }
}
