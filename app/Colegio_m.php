<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colegio_m extends Model
{
    protected $table = 'colegio_m';
    protected $primaryKey = 'id_colegio';

    public function grados(){
        return $this->hasMany('App\Grado_m');
    }
    public function docentes(){
        return $this->hasMany('App\Docente_d');
    }
}
