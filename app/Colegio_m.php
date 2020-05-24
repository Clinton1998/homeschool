<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colegio_m extends Model
{
    protected $table = 'colegio_m';
    protected $primaryKey = 'id_colegio';

    public function grados(){
        return $this->hasMany('App\Grado_m','id_colegio');
    }
    public function docentes(){
        return $this->hasMany('App\Docente_d','id_colegio');
    }
    public function comunicados(){
        return $this->hasMany('App\Comunicado_d','id_colegio');
    }

    //relaciones para facturacion electronica
    public function tipos_de_documento(){
        return $this->belongsToMany('App\Tipo_documento_m', 'serie_d', 'id_colegio', 'id_tipo_documento')->withPivot('id_serie','c_documento_afectado', 'c_serie','b_principal');
    }
    public function tributos(){
        return $this->belongsToMany('App\Tributo_m', 'producto_servicio_d', 'id_colegio', 'id_tributo')->withPivot('id_producto_servicio','c_codigo','c_tipo_codigo','c_nombre','c_tipo','c_unidad','n_precio_sin_igv','n_precio_con_igv')->withTimestamps();
    }
}
