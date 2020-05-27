<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento_m extends Model
{
    protected $table = 'tipo_documento_m';
    protected $primaryKey = 'id_tipo_documento';

    public function colegios(){
        return $this->belongsToMany('App\Colegio_m','serie_d', 'id_tipo_documento', 'id_colegio')->withPivot('id_serie','c_documento_afectado', 'c_serie','b_principal');;
    }

    //pivot table preferencia_d
    public function tipos_de_impresion(){
        return $this->belongsToMany('App\Tipo_impresion_m', 'preferencia_d', 'id_tipo_documento', 'id_tipo_impresion');
    }
    public function series(){
        return $this->belongsToMany('App\Serie_d', 'preferencia_d', 'id_tipo_documento', 'id_serie');
    }
    public function usuarios(){
        //return $this->belongsToMany('App\User', 'preferencia_d', 'id_tipo_documento', 'id');
        return $this->belongsToMany('App\User', 'preferencia_d', 'id_tipo_documento', 'id_usuario');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
}
