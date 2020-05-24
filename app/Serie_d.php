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

    //pivot table preferencia_d
    public function tipos_de_documento(){
        return $this->belongsToMany('App\Tipo_documento_m', 'preferencia_d', 'id_serie', 'id_tipo_documento');
    }
    public function tipos_de_impresion(){
        return $this->belongsToMany('App\Tipo_impresion_m', 'preferencia_d', 'id_serie', 'id_tipo_impresion');
    }
    public function usuarios(){
        //return $this->belongsToMany('App\User', 'preferencia_d', 'ss', 'id');
        return $this->belongsToMany('App\User', 'preferencia_d', 'id_serie', 'id_usuario');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
}
