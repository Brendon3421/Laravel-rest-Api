<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use App\Models\Role;
use App\Models\RoleUser;

class HomeController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $generos = Genero::all();
        $role = Role::all();
        $roleUser = RoleUser::all();

        return view('index', compact('generos', 'role','roleUser'));
    }
    public function Dashboard()
    {
        return view('dashboard');
    }
}
