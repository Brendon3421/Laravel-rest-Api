<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genero;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function index()
    { 
        $generos = Genero::all();
        return view('index', compact('generos'));
    }
    public function Dashboard()
    { 
        
        return view('dashboard');
        
    }
}
