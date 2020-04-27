<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria_d extends Model
{
    protected $table = 'categoria_d';
    protected $primaryKey = 'id_categoria';

    public function secciones(){
        return $this->belongsToMany('App\Seccion_d','seccion_categoria_p', 'id_categoria', 'id_seccion');
    }
    public function docentes(){
        return $this->belongsToMany('App\Docente_d', 'docente_seccion_p', 'id_categoria', 'id_docente');
    }
}
