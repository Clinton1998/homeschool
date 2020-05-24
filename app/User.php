<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function docente(){
        return $this->belongsTo('App\Docente_d','id_docente');
    }

    public function alumno(){
        return $this->belongsTo('App\Alumno_d','id_alumno');
    }
    public function isOnline(){
        return Cache::has('user-is-online-'.$this->id);
    }

    public function grupos(){
        return $this->belongsToMany('App\Group', 'group_user', 'user_id', 'group_id');
    }

    public function herramientas(){
        return $this->hasMany('App\Herramienta_d','id_usuario');
    }
    //pivot table preferencia_d(revisar los id)
    public function tipos_de_documento(){
        return $this->belongsToMany('App\Tipo_documento_m', 'preferencia_d', 'id', 'id_tipo_documento');
    }
    public function tipos_de_impresion(){
        return $this->belongsToMany('App\Tipo_impresion_m', 'preferencia_d', 'id', 'id_tipo_impresion');
    }
    public function series(){
        return $this->belongsToMany('App\Serie_d', 'preferencia_d', 'id', 'id_serie');
    }
}
