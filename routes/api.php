<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/{user}', [UserController::class, 'show']); //get http://127.0.0.1:8000/api/users/1 , exibe conteudo de um usuario especifico
Route::post('/users', [UserController::class, 'store']); //post - http://127.0.0.1:8000/api/users
Route::put('/users/{user}', [UserController::class, 'update']); //put  http://127.0.0.1:8000/api/users/1 , edita conteudo de um usuario especifico
Route::delete('/users/{user}', [UserController::class, 'destroy']); //delete  http://127.0.0.1:8000/api/users/1 , deletar  usuario especifico
route::post('/login', [LoginController::class , 'auth'])->name('login'); // http://127.0.0.1:8000/api/login/{information users} , rota publica de login do usuario ao sistema
// rotas que sao necessarios os tokens de autenticacao 
route::group(['middleware'=> ['auth:sanctum']],function(){
    Route::get('/users', [UserController::class, 'index']); //get http://127.0.0.1:8000/api/users?page=1 exibe conteudo de  todos os usuarios 

    Route::post('/logout/{user}', [LoginController::class, 'logout']);


});