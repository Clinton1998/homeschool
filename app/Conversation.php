<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];
    public function fromGroup(){
        return $this->hasOne(Group::class,'id','group_id');
    }
    public function emisor(){
        return $this->belongsTo('App\User','user_id');
    }
    public function group(){
        return $this->belongsTo('App\Group','group_id');
    }
}
