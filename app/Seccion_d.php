<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion_d extends Model
{
    protected $table = 'seccion_d';
    protected $primaryKey = 'id_seccion';

    public function grado(){
        return $this->belongsTo('App\Grado_m','id_grado');
    }
    public function categorias(){
        return $this->belongsToMany('App\Categoria_d', 'seccion_categoria_p', 'id_seccion', 'id_categoria');
    }
    public function docentes(){
        return $this->belongsToMany('App\Docente_d', 'docente_seccion_p', 'id_seccion', 'id_docente');
    }

    public function alumnos(){
        return $this->hasMany('App\Alumno_d','id_seccion');
    }
}
