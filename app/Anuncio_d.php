<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anuncio_d extends Model
{
    protected $table = 'anuncio_d';
    protected $primaryKey = 'id_anuncio';

    public function seccion(){
        return $this->belongsTo('App\Seccion_d','id_seccion');
    }
}
