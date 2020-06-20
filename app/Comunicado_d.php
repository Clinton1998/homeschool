<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunicado_d extends Model
{
    protected $table = 'comunicado_d';
    protected $primaryKey = 'id_comunicado';

    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }
    public function archivos(){
        return $this->hasMany('App\Archivo_comunicado_d','id_comunicado');
    }
}
