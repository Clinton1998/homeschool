<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_d extends Model
{
    protected $table = 'comentario_d';
    protected $primaryKey = 'id_comentario';

    public function tarea(){
        return $this->belongsTo('App\Tarea_d','id_tarea');
    }

    public function comenta(){
        return $this->belongsTo('App\User','id_usuario');
    }

    public function parent() 
    {
        return $this->belongsTo('App\Comentario_d', 'id_comentario');
    }
 
    public function replies() 
    {
        return $this->hasMany('App\Comentario_d', 'id_comentario');
    }
}
