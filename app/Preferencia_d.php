<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preferencia_d extends Model
{
    protected $table = 'preferencia_d';
    protected $primaryKey = 'id_preferencia';

    public function tipo_documento(){
        return $this->belongsTo('App\Tipo_documento_m','id_tipo_documento');
    }
    public function tipo_impresion(){
        return $this->belongsTo('App\Tipo_impresion_m','id_tipo_impresion');
    }
    public function serie(){
        return $this->belongsTo('App\Serie_d','id_serie');
    }
    //revisar el id del usuario
    public function usuario(){
        return $this->belongsTo('App\User','id_usuario');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
}
