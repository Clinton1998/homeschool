<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessageForGroup;
use App\Events\GroupCreated;
use App;
use Auth;


class GroupController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function crear(Request $request){
        //return response()->json($request->all());
        $group = new App\Group;
        $group->name = $request->input('name');
        $group->creador = Auth::user()->id;
        $group->save();

        $users = collect($request->input('users'));
        $users->push(Auth::user()->id);
        $group->users()->attach($users);

        broadcast(new GroupCreated($group))->toOthers();
        return response()->json($group);
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

        return response()->json($conversations);
    }
}
