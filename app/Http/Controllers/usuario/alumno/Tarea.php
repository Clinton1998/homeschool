<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Tarea extends Controller
{
    public function index(){
        return view('tareasalumno');
    }
}
