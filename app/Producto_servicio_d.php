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
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }
    //pivot detalle_comprobante_d
    public function comprobantes(){
        return $this->belongsToMany('App\Comprobante_d', 'detalle_comprobante_d', 'id_producto', 'id_comprobante')
        ->withPivot('c_codigo_producto','c_nombre_producto','c_unidad_producto',
        'c_tributo_producto','c_informacion_adicional','b_tipo_detalle','n_cantidad',
        'n_valor_unitario','n_precio_unitario','n_porcentaje_igv','n_total_base',
        'n_total_igv','n_total_icbper','n_total_impuesto','n_total_detalle');
    }
    //pivot detalle_nota_d
    public function notas(){
        return $this->belongsToMany('App\Nota_d', 'detalle_nota_d', 'id_producto', 'id_nota')
        ->withPivot('c_codigo_producto','c_nombre_producto','c_unidad_producto',
        'c_tributo_producto','c_informacion_adicional','b_tipo_detalle','n_cantidad',
        'n_valor_unitario','n_precio_unitario','n_porcentaje_igv','n_total_base',
        'n_total_igv','n_total_icbper','n_total_impuesto','n_total_detalle');
    }
}
