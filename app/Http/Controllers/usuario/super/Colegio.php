<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App;
use Auth;

class Colegio extends Controller
{
    private $logos_path;

    public function __construct()
    {
        $this->logos_path = storage_path('app/public/colegio');
    }

    public function index()
    {
        //verificamos si el usuario es superadministrador
        $usuario = App\User::findOrFail(Auth::user()->id);
        if (is_null($usuario->id_docente) && is_null($usuario->id_alumno) && $usuario->b_root != 1) {
            $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();
            return view('colegiosuper', compact('colegio'));
        } else {
            return redirect('/home');
        }
    }

    public function actualizar_info(Request $request)
    {
        //investigamos el colegio con el cual estamos logueados
        $colegio = App\Colegio_m::where('id_superadministrador', '=', Auth::user()->id)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'ruc' => [
                    'required',
                    Rule::unique('colegio_m', 'c_ruc')->ignore($colegio->id_colegio, 'id_colegio'),
                ],
                'razon_social' => 'required',
                'correo' => 'required|email',
                'telefono' => 'required|numeric',
                'dni' => 'required|numeric',
                'nombre' => 'required'
            ],
            [
                'required' => 'El campo es requerido',
                'unique' => 'El RUC ya está en uso',
                'numeric' => 'Debe ser un número',
                'email' => 'Debe ser un correo válido'
            ]
        );

        if ($validator->fails()) {
            return redirect('super/colegio')
                ->withErrors($validator)
                ->withInput();
        }

        //proceso para actualizar el colegio
        $colegio->c_ruc = $request->input('ruc');
        $colegio->c_razon_social = $request->input('razon_social');
        $colegio->c_correo = $request->input('correo');
        $colegio->c_telefono = $request->input('telefono');
        $colegio->c_dni_representante = $request->input('dni');
        $colegio->c_representante_legal = $request->input('nombre');
        $colegio->modificador = Auth::user()->id;
        $colegio->save();
        return redirect('super/colegio');
    }

    public function cambiar_logo(Request $request)
    {
        //verificamos el usuario
        $usuario = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        if (!is_null($colegio) && !empty($colegio)) {
            $logo = $request->file('logocolegio');
            if (!is_dir($this->logos_path)) {
                mkdir($this->logos_path, 0777);
            }
            $name = sha1(date('YmdHis'));
            $save_name = $name . '.' . $logo->getClientOriginalExtension();
            $resize_name = $name . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->logos_path . '/' . $resize_name);
            $logo->move($this->logos_path, $save_name);

            //actualizamos el logo del colegio
            $colegio->c_logo = $resize_name;
            $colegio->modificador = $usuario->id;
            $colegio->save();
        }
        return redirect('super/colegio');
    }

    public function logo($fileName)
    {
        $content = Storage::get('public/colegio/' . $fileName);
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
}
