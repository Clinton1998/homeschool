<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_nota_d extends Model
{
    protected $table = 'detalle_nota_d';
    protected $primaryKey = 'id_detalle_nota';

    public function nota(){
        return $this->belongsTo('App\Nota_d','id_nota');
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
