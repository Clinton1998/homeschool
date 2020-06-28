<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo_tarea_d extends Model
{
  protected $table = 'archivo_tarea_d';
  protected $primaryKey = 'id_archivo';

  public function tarea(){
      return $this->belongsTo('App\Tarea_d','id_tarea');
  }
}
