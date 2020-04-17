<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Calendario extends Controller
{
    public function index(){
        return view('calendarioalumno');
    }
}
