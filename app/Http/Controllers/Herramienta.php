<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;
class Herramienta extends Controller
{   
    private $fotos_path;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->fotos_path = storage_path('app/public/herramienta');
    }

    public function listar(){
        $herramientas = App\Herramienta_d::where('id_usuario','=',Auth::user()->id)->orderBy('c_nombre','ASC')->get();
        $datos = array(
            'herramientas' => $herramientas
        );
        return response()->json($datos);
    }

    public function agregar(Request $request){
        //el logo solo debe ser o fisico o un link de la imagen
        //tamaño maximo 256 MB cuando es logo fisico
        //logo_fisico o logo_link, uno de los dos debe quedar null EN DDBB
        /* $request->validate([
            'nombre' => 'required',
            'logo_fisico' => 'file|mimes:jpeg,png,gif|max:256000',
            'logo_link' => 'url',
            'link' => 'required|url'
        ]); */

        $herramienta = new App\Herramienta_d;
        $herramienta->id_usuario = Auth::user()->id;
        $herramienta->c_nombre = $request->input('nombre');
        $herramienta->c_link = $request->input('link');
        $herramienta->creador = Auth::user()->id;
        $herramienta->save();

        $logo_fisico = $request->file('logo_fisico');

        if(!is_null($logo_fisico) && !empty($logo_fisico)){
            //guardamos el logo fisico
            if (!is_dir($this->fotos_path)) {
                mkdir($this->fotos_path, 0777);
            }
            $name = sha1(date('YmdHis'));
            //$save_name = $name . '.' . $foto->getClientOriginalExtension();
            $resize_name = $name . '.' . $logo_fisico->getClientOriginalExtension();
            Image::make($logo_fisico)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->fotos_path . '/' . $resize_name);
            //actualizamos el logo de la herramienta
            $herramienta->c_logo_fisico = $resize_name;
            $herramienta->save();
        }else{
            //guardamos un link del logo
            $herramienta->c_logo_link = $request->input('logo_link');
            $herramienta->save();
        }
        return response()->json($herramienta);
    }

    public function actualizar(Request $request){

        $herramienta = App\Herramienta_d::findOrFail($request->id_tool);
        $herramienta->c_nombre = $request->input('nombre');
        $herramienta->c_link = $request->input('link');
        $herramienta->modificador = Auth::user()->id;
        $herramienta->save();

        $logo_link = $request->input('logo_link');
        $logo_fisico = $request->file('logo_fisico');

        if (!is_null($logo_fisico) && !empty($logo_fisico)) {

            if (!is_null($herramienta->c_logo_fisico)) {
                unlink($this->fotos_path.'/'.$herramienta->c_logo_fisico);
            }

            if (!is_dir($this->fotos_path)) {
                mkdir($this->fotos_path, 0777);
            }

            $name = sha1(date('YmdHis'));
            $resize_name = $name . '.' . $logo_fisico->getClientOriginalExtension();
            
            Image::make($logo_fisico)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->fotos_path . '/' . $resize_name);

            $herramienta->c_logo_fisico = $resize_name;
            $herramienta->save();
        }
        elseif (!is_null($logo_link) && !empty($logo_link)) {
            
            if (!is_null($herramienta->c_logo_fisico)) {
                unlink($this->fotos_path.'/'.$herramienta->c_logo_fisico);
                $herramienta->c_logo_fisico = NULL;
            }

            $herramienta->c_logo_link = $request->input('logo_link');
            $herramienta->save();
        }

        return response()->json($herramienta);
    }
    
    public function eliminar(Request $request){

        $herramienta = App\Herramienta_d::findOrFail($request->id_herramienta);

        /* if(!is_null($herramienta->c_logo_fisico) && !empty($herramienta->c_logo_fisico) ){
            unlink($this->fotos_path.'/'.$herramienta->c_logo_fisico);
        } */

        $herramienta->delete();
        
        $herramientas = App\Herramienta_d::where('id_usuario','=',Auth::user()->id)->orderBy('created_at','DESC')->get();
        
        $datos = array(
            'herramientas' => $herramientas
        );

        return response()->json($datos);
    }

    public function buscar(Request $request){
        //parametro de entrada nombre
        $herramientas = App\Herramienta_d::where([
            ['id_usuario','=',Auth::user()->id],
            ['c_nombre','like','%'.$request->input('nombre').'%']
        ])->get();

        $datos = array(
            'herramientas' => $herramientas
        );
        return response()->json($datos);
    }

    public function logo_fisico($fileName)
    {
        $content = Storage::get('public/herramienta/' . $fileName);
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
