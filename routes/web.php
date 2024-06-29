<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//rota web para logar
Route::get('/login', [LoginController::class, 'authView'])->name('/login');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login/auth');

//rota web para registrar
Route::get('/registrar', [LoginController::class, 'authRegister'])->name('register');
Route::post('/registrar/post', [UserController::class, 'store'])->name('register.post');

//rota web para logar
Route::get('/home', [HomeController::class , 'show'])->name('home');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login/auth');
