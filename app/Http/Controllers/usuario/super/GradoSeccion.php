<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradoSeccion extends Controller
{
    public function index(){
        return view('super.gradoseccion');
    }
}
