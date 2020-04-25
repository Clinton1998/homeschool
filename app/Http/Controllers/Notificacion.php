<?php

namespace App\Http\Controllers;

use Auth;

class Notificacion extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listar()
    {
        return Auth::user()->unreadNotifications;
    }


    public function marcar_como_leido(Request $request)
    {
        Auth::user()->unreadNotifications->find($request->id_notification)->markAsRead();
    }

    public function marcar_todo_como_leido()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }
}
