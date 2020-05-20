<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda_m extends Model
{
    protected $table = 'moneda_m';
    protected $primaryKey = 'id_moneda';

    public function creador(){
        return $this->belongsTo('App\User','id');
    }
    public function modificador(){
        return $this->belongsTo('App\User','id');
    }
}
