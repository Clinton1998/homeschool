<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea_d extends Model
{
    protected $table = 'tarea_d';
    protected $primaryKey = 'id_tarea';

    public function categoria(){
        return $this->belongsTo('App\Categoria_d','id_categoria');
    }
    public function docente(){
        return $this->belongsTo('App\Docente_d','id_docente');
    }
    public function alumnos_asignados(){
        return $this->belongsToMany('App\Alumno_d', 'alumno_tarea_respuesta_p', 'id_tarea', 'id_alumno')->withPivot('id_alumno_docente_tarea','c_estado', 'id_respuesta','updated_at');;
    }
    public function comentarios(){
        return $this->hasMany('App\Comentario_d','id_tarea');
    }
}
