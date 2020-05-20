<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tributo_m extends Model
{
    protected $table = 'tributo_m';
    protected $primaryKey = 'id_tributo';

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }

    public function colegios(){
        return $this->belongsToMany('App\Colegio_m', 'producto_servicio_d', 'id_tributo', 'id_colegio')->withPivot('id_producto_servicio','c_codigo','c_tipo_codigo','c_nombre','c_tipo','c_unidad','n_precio_sin_igv','n_precio_con_igv')->withTimestamps();
    }
}
