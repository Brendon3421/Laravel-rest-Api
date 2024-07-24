<?php

use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/Nexustalk', [HomeController::class, 'index'])->name('home.page');
//rota web para logar
Route::get('/login', [LoginController::class, 'authView'])->name('/login');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login/auth');

//rota web para registrar
Route::get('/registrar', [LoginController::class, 'authRegister'])->name('register.view.api');
Route::post('/registrar/post', [UserController::class, 'store'])->name('register.post.api');

//rota web para logar
Route::get('/dashboard', [HomeController::class , 'dashboard'])->name('/dashboard');

