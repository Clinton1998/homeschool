<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento_identidad_m extends Model
{
    protected $table = 'documento_identidad_m';
    protected $primaryKey = 'id_documento_identidad';

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
