<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente_d extends Model
{
    protected $table = 'docente_d';
    protected $primaryKey = 'id_docente';
    
    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }
    public function secciones(){
        return $this->belongsToMany('App\Seccion_d','docente_seccion_p', 'id_docente', 'id_seccion');
    }
    public function categorias(){
        return $this->belongsToMany('App\Categoria_d','docente_categoria_p', 'id_docente', 'id_categoria');
    }
    //las tareas que el docente asignó
    public function tareas(){
        return $this->hasMany('App\Tarea_d','id_docente');
    }
}
