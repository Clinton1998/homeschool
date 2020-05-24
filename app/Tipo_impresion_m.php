<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_impresion_m extends Model
{
    protected $table = 'tipo_impresion_m';
    protected $primaryKey = 'id_tipo_impresion';
    //pivot table preferencia_d
    public function tipos_de_documento(){
        return $this->belongsToMany('App\Tipo_documento_m', 'preferencia_d', 'id_tipo_impresion', 'id_tipo_documento');
    }
    public function series(){
        return $this->belongsToMany('App\Serie_d', 'preferencia_d', 'id_tipo_impresion', 'id_serie');
    }
    public function usuarios(){
        //return $this->belongsToMany('App\User', 'preferencia_d', 'ss', 'id');
        return $this->belongsToMany('App\User', 'preferencia_d', 'id_tipo_impresion', 'id_usuario');
    }
    
    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
}
