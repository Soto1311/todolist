<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;

class EstadosController extends Controller
{
    public function index(){
        $estados = Estado::where('deleted', 0)
                        ->get();
        
        return view('estados.estados', ['estados' => $estados]);
    }
    
    public function getestados(){
        $estados = Estado::where('deleted', 0)
                        ->get();
        
        return $estados;
    }
}
