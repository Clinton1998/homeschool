<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_servicio_d extends Model
{
    protected $table = 'producto_servicio_d';
    protected $primaryKey = 'id_producto_servicio';
    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }
    public function tributo(){
        return $this->belongsTo('App\Tributo_m','id_tributo');
    }
    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
