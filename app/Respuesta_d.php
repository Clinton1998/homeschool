<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_d extends Model
{
    protected $table = 'respuesta_d';
    protected $primaryKey = 'id_respuesta';

    public function archivos(){
        return $this->hasMany('App\Archivo_respuesta_d','id_respuesta');
    }
}
