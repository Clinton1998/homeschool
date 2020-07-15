<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Comentario_d;

class NewCommentTask implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $comentario;
    public function __construct(Comentario_d $comentario)
    {
      $this->comentario = $comentario;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      $id_usuarios = [];
      if(!is_null($this->comentario->comenta->id_docente)){
        //docente comentó
        $alumnos_asignados = $this->comentario->tarea->alumnos_asignados()->where('alumno_d.estado','=',1)->get();
        foreach($alumnos_asignados as $item_alumno){
          $id_usuarios[] = $item_alumno->usuario->id;
        }
      }else{
        //algun alumno(a) comentó
        $id_usuarios[] = $this->comentario->tarea->creador;
        $alumnos_asignados = $this->comentario->tarea->alumnos_asignados()->where([
          ['alumno_d.estado','=',1],
          ['alumno_d.id_alumno','<>',$this->comentario->comenta->id_alumno],
        ])->get();
        foreach($alumnos_asignados as $item_alumno){
          $id_usuarios[] = $item_alumno->usuario->id;
        }
      }
      $channels = [];
      for($i = 0; $i<count($id_usuarios); $i++){
          array_push($channels,new PrivateChannel('commentfortask.'.$id_usuarios[$i]));
      }
      return $channels;

    }
}
