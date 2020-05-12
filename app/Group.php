<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function creador(){
        return $this->belongsTo('App\User','id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');
    }
}
