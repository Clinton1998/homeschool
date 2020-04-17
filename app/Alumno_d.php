<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno_d extends Model
{
    protected $table = 'alumno_d';
    protected $primaryKey = 'id_alumno';

    public function seccion(){
        return $this->belongsTo('App\Seccion_d','id_seccion');
    }

    public function tareas_asignados(){
        return $this->belongsToMany('App\Tarea_d', 'alumno_tarea_respuesta_p', 'id_alumno', 'id_tarea')->withPivot('id_alumno_docente_tarea','c_estado', 'id_respuesta');
    }
}
