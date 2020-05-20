<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motivo_nota_m extends Model
{
    protected $table = 'motivo_nota_m';
    protected $primaryKey = 'id_motivo_nota';

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
