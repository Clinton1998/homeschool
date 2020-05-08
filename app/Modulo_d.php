<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo_d extends Model
{
    protected $table = 'modulo_d';
    protected $primaryKey = 'id_modulo';

    public function archivos(){
        return $this->hasMany('App\Archivo_d','id_modulo');
    }
}
