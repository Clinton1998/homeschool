<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Events\NotificationRead;
use Auth;

class Notificacion extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listar()
    {
        return Auth::user()->unreadNotifications;
    }


    public function marcar_como_leido(Request $request)
    {

        Auth::user()->unreadNotifications->find($request->id_notification)->markAsRead();
    }

    public function marcar_todo_como_leido()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function marcar_como_leido_tipo_comunicado(Request $request)
    {
        $comunicado = App\Comunicado_d::findOrFail($request->input('id_comunicado'));
        //obtengo las notificaciones del usuario actual
        $notificaciones = Auth::user()->unreadNotifications()->get();
        $notificacion_a_marcar = null;
        foreach ($notificaciones as $notificacion) {
            if ($notificacion->data['notificacion']['tipo']=='comunicado') {
                $id_comunicado = (int) $notificacion->data['notificacion']['comunicado']['id_comunicado'];
                if ($id_comunicado === $comunicado->id_comunicado) {
                    $notificacion_a_marcar = $notificacion;
                }
            }
        }
        $marcado = false;
        if(!is_null($notificacion_a_marcar)){
            $notificacion_a_marcar->read_at  = date('Y-m-d H:i:s');
            $notificacion_a_marcar->save();
            $marcado = true;
            //en el futuro podria dispararse un evento broadcast para que actualize la campa

            broadcast(new NotificationRead($notificacion_a_marcar->toArray()));
        }
        $datos = array('marcadocomoleido' => $marcado, 'notificacionmarcada' => $notificacion_a_marcar);
        return response()->json($datos);
    }

    public function marcar_como_leido_tipo_anuncio(Request $request){
        $anuncio = App\Anuncio_d::findOrFail($request->input('id_anuncio'));
        //obtengo las notificaciones del usuario actual
        $notificaciones = Auth::user()->unreadNotifications()->get();
        $notificacion_a_marcar = null;
        foreach ($notificaciones as $notificacion) {
            if ($notificacion->data['notificacion']['tipo']=='anuncio') {
                $id_anuncio = (int) $notificacion->data['notificacion']['anuncio']['id_anuncio'];
                if ($id_anuncio === $anuncio->id_anuncio) {
                    $notificacion_a_marcar = $notificacion;
                }
            }
        }
        $marcado = false;
        if(!is_null($notificacion_a_marcar)){
            $notificacion_a_marcar->read_at  = date('Y-m-d H:i:s');
            $notificacion_a_marcar->save();
            $marcado = true;

            broadcast(new NotificationRead($notificacion_a_marcar->toArray()));
        }
        $datos = array(
            'marcadocomoleido' => $marcado,
            'notificacionmarcada' => $notificacion_a_marcar
        );
        return response()->json($datos);
    }
}
