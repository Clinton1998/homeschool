<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota_d extends Model
{
    protected $table = 'nota_d';
    protected $primaryKey = 'id_nota';

    /**
     * Falta implementar relaciones pivot con 8 tablas
     */
    public function colegio()
    {
        return $this->belongsTo('App\Colegio_m', 'id_colegio');
    }
    public function serie()
    {
        return $this->belongsTo('App\Serie_d', 'id_serie');
    }
    public function alumno()
    {
        return $this->belongsTo('App\Alumno_d', 'id_alumno');
    }
    public function comprobante()
    {
        return $this->belongsTo('App\Comprobante_d', 'id_comprobante');
    }
    public function tipo_documento()
    {
        return $this->belongsTo('App\Tipo_documento_m', 'id_tipo_documento');
    }
    public function moneda()
    {
        return $this->belongsTo('App\Moneda_m', 'id_moneda');
    }
    public function documento_identidad()
    {
        return $this->belongsTo('App\Documento_identidad_m', 'id_documento_identidad');
    }
    public function tipo_impresion()
    {
        return $this->belongsTo('App\Tipo_impresion_m', 'id_tipo_impresion');
    }

    public function creador()
    {
        return $this->belongsTo('App\User', 'creador');
    }
    public function modificador()
    {
        return $this->belongsTo('App\User', 'modificador');
    }

    //pivot detalle_nota_d
    public function productos(){
        return $this->belongsToMany('App\Producto_servicio_d', 'detalle_nota_d', 'id_nota', 'id_producto')
        ->withPivot('c_codigo_producto','c_nombre_producto','c_unidad_producto',
        'c_tributo_producto','c_informacion_adicional','b_tipo_detalle','n_cantidad',
        'n_valor_unitario','n_precio_unitario','n_porcentaje_igv','n_total_base',
        'n_total_igv','n_total_icbper','n_total_impuesto','n_total_detalle');
    }
}
