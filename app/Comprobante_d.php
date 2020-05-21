<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante_d extends Model
{
    protected $table = 'comprobante_d';
    protected $primaryKey = 'id_comprobante';
/**
 * Falta implementar relaciones pivot con 7 tablas
 */
    public function colegio(){
        return $this->belongsTo('App\Colegio_m','id_colegio');
    }
    public function serie(){
        return $this->belongsTo('App\Serie_d','id_serie');
    }
    public function alumno(){
        return $this->belongsTo('App\Alumno_d','id_alumno');
    }
    public function tipo_documento(){
        return $this->belongsTo('App\Tipo_documento_m','id_tipo_documento');
    }
    public function moneda(){
        return $this->belongsTo('App\Moneda_m','id_moneda');
    }
    public function documento_identidad(){
        return $this->belongsTo('App\Documento_identidad_m','id_documento_identidad');
    }
    public function tipo_impresion(){
        return $this->belongsTo('App\Tipo_impresion_m','id_tipo_impresion');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador');
    }
    public function modificador(){
        return $this->belongsTo('App\User','modificador');
    }

    //pivot detalle_comprobante_d
    public function productos(){
        return $this->belongsToMany('App\Producto_servicio_d', 'detalle_comprobante_d', 'id_comprobante', 'id_producto')
        ->withPivot('c_codigo_producto','c_nombre_producto','c_unidad_producto',
        'c_tributo_producto','c_informacion_adicional','b_tipo_detalle','n_cantidad',
        'n_valor_unitario','n_precio_unitario','n_porcentaje_igv','n_total_base',
        'n_total_igv','n_total_icbper','n_total_impuesto','n_total_detalle');
    }
}
