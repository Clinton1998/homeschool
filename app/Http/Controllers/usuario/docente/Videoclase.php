<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Videoclase extends Controller
{
    public function index(){
        return view('docente.videoclase');
    }
}
