<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Videoconferencia extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('super.videoconf');
    }
}
