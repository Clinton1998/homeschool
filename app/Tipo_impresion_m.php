<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_impresion_m extends Model
{
    protected $table = 'tipo_impresion_m';
    protected $primaryKey = 'id_tipo_impresion';

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
