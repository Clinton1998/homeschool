<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Herramienta_d extends Model
{
    protected $table = 'herramienta_d';
    protected $primaryKey = 'id_herramienta';

    public function usuario(){
        return $this->belongsTo('App\User','id_usuario');
    }
}
