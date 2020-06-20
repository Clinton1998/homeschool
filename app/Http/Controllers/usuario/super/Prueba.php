<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use App\Events\AlertSimple;
use Illuminate\Http\Request;

class Prueba extends Controller
{
    public function probar(){
        broadcast(new AlertSimple([3,1,5,6,7,8,9],'Titulo xd','text xd','info',5000,'/assets/images/Logo-HS.png'));
    }
}
