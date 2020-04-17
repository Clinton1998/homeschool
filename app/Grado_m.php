<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado_m extends Model
{
    protected $table = 'grado_m';
    protected $primaryKey = 'id_grado';

    public function secciones(){
        return $this->hasMany('App\Seccion_d','id_grado');
    }
    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }
}
