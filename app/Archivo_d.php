<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo_d extends Model
{
    protected $table = 'archivo_d';
    protected $primaryKey = 'id_archivo';

    public function modulo(){
        return $this->belongsTo('App\Modulo_d','id_modulo');
    }
}
