<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo_comunicado_d extends Model
{
    protected $table = 'archivo_comunicado_d';
    protected $primaryKey = 'id_archivo';

    public function comunicado(){
        return $this->belongsTo('App\Comunicado_d','id_comunicado');
    }
}
