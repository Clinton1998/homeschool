<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento_m extends Model
{
    protected $table = 'tipo_comunicado_m';
    protected $primaryKey = 'id_tipo_comunicado';
    
    public function colegios(){
        return $this->belongsToMany('App\Colegio_m','serie_d', 'id_tipo_documento', 'id_colegio')->withPivot('id_serie','c_documento_afectado', 'c_serie','b_principal');;
    }
    
    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
