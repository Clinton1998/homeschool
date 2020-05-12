<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Conversation;
use App\Colegio_m;
use App\Docente_d;
use App\Alumno_d;
use App\Http\Controllers\usuario\docente\Alumno;
use Auth;

class NewMessageForGroup implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $conversation;
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach($this->conversation->group->users()->where('users.id','<>',Auth::user()->id)->get() as $user){
            array_push($channels,new PrivateChannel('messagesforgroup.'.$user->id));
        }
        return $channels;
    }
    public function broadcastWith(){
        $this->conversation->load('fromContact');
        $contact = $this->conversation->fromContact;
        $nombre_emisor = '';
        if(is_null($contact->id_docente) && is_null($contact->id_alumno) && $contact->b_root==0){
            $colegio= Colegio_m::where([
                'id_superadministrador' => $contact->id
            ])->first();
            $nombre_emisor = $colegio->c_representante_legal;
        }else if(!is_null($contact->id_docente)){
            $docente = Docente_d::findOrFail($contact->id_docente);
            $nombre_emisor = $docente->c_nombre;
        }else if(!is_null($contact->id_alumno)){
            $alumno = Alumno_d::findOrFail($contact->id_alumno);
            $nombre_emisor = $alumno->c_nombre;
        }
        $this->conversation->nombre_emisor = $nombre_emisor;
        return ["conversation" => $this->conversation];
    }
}
