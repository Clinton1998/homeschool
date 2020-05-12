<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessageForGroup;
use App\Events\GroupCreated;
use App\Events\GroupDeleted;
use Illuminate\Support\Facades\DB;
use App;
use Auth;


class GroupController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function crear(Request $request){
        $group = new App\Group;
        $group->name = $request->input('name');
        $group->creador = Auth::user()->id;
        $group->save();

        $users = collect($request->input('users'));
        $users->push(Auth::user()->id);
        $group->users()->attach($users);

        broadcast(new GroupCreated($group))->toOthers();
        $datos = array(
            'correcto' => TRUE
        );
        return response()->json($datos);
    }

    public function send_message(Request $request){
        
        $conversation = new App\Conversation;
        $conversation->message = $request->input('message');
        $conversation->group_id = $request->input('group_id');
        $conversation->user_id = Auth::user()->id;
        $conversation->save();
        $conversation->load('emisor');
        broadcast(new NewMessageForGroup($conversation));
        //broadcast(new NewMessageForGroup($conversation))->toOthers();

        return $conversation->load('emisor');
    }
    public function conversations($group_id){
        $group  = App\Group::findOrFail($group_id);

        $conversations = App\Conversation::where([
            'group_id' => $group_id
        ])->orderBy('created_at','ASC')->get();
        $conversations->load('emisor');

        $conversations = $conversations->map(function ($conversation){
            $nombre_emisor = 'Clinton XD';
            if(is_null($conversation->emisor->id_docente) && is_null($conversation->emisor->id_alumno) && $conversation->emisor->b_root==0){
                $colegio = App\Colegio_m::where([
                    'id_superadministrador' => $conversation->emisor->id
                ])->first();
                $nombre_emisor = $colegio->c_representante_legal;
            }else if(!is_null($conversation->emisor->id_docente)){
                $nombre_emisor = $conversation->emisor->docente->c_nombre;
            }else if(!is_null($conversation->emisor->id_alumno)){
                $nombre_emisor = $conversation->emisor->alumno->c_nombre;
            }
            $conversation->nombre_emisor = $nombre_emisor;
            return $conversation;
        });
        $usuarios = $group->users()->where('users.id','<>',Auth::user()->id)->get();
        $usuarios = $usuarios->map(function ($user){
            $nombre_usuario = '';
            if(is_null($user->id_docente) && is_null($user->id_alumno) && $user->b_root==0){
                $colegio = App\Colegio_m::where([
                    'id_superadministrador' => $user->id
                ])->first();
                $nombre_usuario = $colegio->c_representante_legal;
            }else if(!is_null($user->id_docente)){
                $nombre_usuario = $user->docente->c_nombre;
            }else if(!is_null($user->id_alumno)){
                $nombre_usuario = $user->alumno->c_nombre;
            }
            $user->nombre_usuario = $nombre_usuario;
            return $user;
        });

        $datos = array(
            'conversations' => $conversations,
            'users' => $usuarios
        );
        return response()->json($datos);
    }
    public function drop(Request $request){
        $group = App\Group::findOrFail($request->input('group_id'));
        $usuarios_notificar = $group->users()->select('users.id')->where('users.id','<>',Auth::user()->id)->get()->toArray();
        //eliminamos las comversaciones de ese grupo
        DB::table('conversations')->where('group_id', '=', $group->id)->delete();
        //eliminamos los usuarios de ese grupo
        DB::table('group_user')->where('group_id', '=', $group->id)->delete();
        //eliminamos el grupo
        $respuesta = $group->delete();

        if($respuesta){
            //transmitimos el evento a pusher
            broadcast(new GroupDeleted($usuarios_notificar))->toOthers();
        }
        $datos = array(
            'eliminado' =>  $respuesta
        );
        return response()->json($datos);
    }
}
