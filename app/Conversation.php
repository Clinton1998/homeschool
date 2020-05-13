<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];
    public function fromContact(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function emisor(){
        return $this->belongsTo('App\User','user_id');
    }
    public function group(){
        return $this->belongsTo('App\Group','group_id');
    }
}
