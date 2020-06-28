<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo_respuesta_d extends Model
{
  protected $table = 'archivo_respuesta_d';
  protected $primaryKey = 'id_archivo';

  public function respuesta(){
      return $this->belongsTo('App\Respuesta_d','id_respuesta');
  }
}
