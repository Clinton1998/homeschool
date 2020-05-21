<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_comprobante_d extends Model
{
    protected $table = 'detalle_comprobante_d';
    protected $primaryKey = 'id_detalle_comprobante';

    public function comprobante(){
        return $this->belongsTo('App\Comprobante_d','id_comprobante');
    }
    public function producto(){
        return $this->belongsTo('App\Producto_servicio_d','id_producto');
    }
    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
}
