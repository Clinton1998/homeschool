<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie_d extends Model
{
    protected $table = 'serie_d';
    protected $primaryKey = 'id_serie';

    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }

    public function tipo_documento(){
        return $this->belongsTo('App\Tipo_documento_m','id_tipo_documento');
    }

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
