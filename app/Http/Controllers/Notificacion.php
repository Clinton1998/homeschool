<?php

namespace App\Http\Controllers;
use Auth;

class Notificacion extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listar(){
       return Auth::user()->unreadNotifications;
    }
}
