<?php

use App\Http\Controllers\Api\AbilitiesController;
use App\Http\Controllers\api\abilityRoleController;
use App\Http\Controllers\Api\AbilityUserController;
use App\Http\Controllers\api\ContatoEmpresaController;
use App\Http\Controllers\Api\ContatosController;
use App\Http\Controllers\Api\EmpresasController;
use App\Http\Controllers\Api\EnderecoController;
use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\RoleUserController;
use App\Http\Controllers\Api\SituacaoController;
use App\Http\Controllers\Api\UserController;
use App\Models\ContatoEmpresa;
use Illuminate\Support\Facades\Route;
//rotas situacao
Route::get('/situacao', [SituacaoController::class, 'index']); //get http://127.0.0.1:8000/api/situacao/ , exibe conteudo das situacao 
Route::get('/situacao/{situacao}', [SituacaoController::class, 'show']); //get http://127.0.0.1:8000/api/situacao/{situacao}, exibe conteudo da situacao especifico do numero da url 
Route::post('/situacao', [SituacaoController::class, 'store']);  //get http://127.0.0.1:8000/api/situacao/ , cria uma situacao 
Route::put('/situacao/{situacao}', [SituacaoController::class, 'update']);  //get http://127.0.0.1:8000/api/situacao/{sistuacao} ,  edita um endereco solicitado 
Route::delete('/situacao/{situacao}', [SituacaoController::class, 'destroy']); //delete  http://127.0.0.1:8000/api/users/1 , deletar  usuario especifico
//rotas Usuario
Route::get('/users/{user}', [UserController::class, 'show']); //get http://127.0.0.1:8000/api/users/1 , exibe conteudo de um usuario especifico
Route::post('/users', [UserController::class, 'store']); //post - http://127.0.0.1:8000/api/users criar usuario 
Route::put('/users/{user}', [UserController::class, 'update']); //put  http://127.0.0.1:8000/api/users/1 , edita conteudo de um usuario especifico
Route::delete('/users/{user}', [UserController::class, 'destroy']); //delete  http://127.0.0.1:8000/api/users/1 , deletar  usuario especifico
route::post('/login', [LoginController::class, 'auth'])->name('login'); // http://127.0.0.1:8000/api/login/{information users} , rota publica de login do usuario ao sistema
//rotas ACL Habilidades
Route::get('/abilities', [AbilitiesController::class, 'index']); // http://127.0.0.1:8000/api/abilities/ , rota para listar habilidades
Route::get('/abilities/{ability}', [AbilitiesController::class, 'show']); // htt[=[=p://127.0.0.1:8000/api/abilities/{abilities} , rota de listar habilidade especifica
Route::post('/abilities', [AbilitiesController::class, 'store']); // http://127.0.0.1:8000/api/abilities/, rota criar habilidade
Route::put('/abilities/{ability}', [AbilitiesController::class, 'update']); // http://127.0.0.1:8000/api/abilities/{abilities}, rota editar habilidade especifica
Route::delete('/abilities/{ability}', [AbilitiesController::class, 'destroy']); // http://127.0.0.1:8000/api/abilities/{ user0s} , rota para excluir habilidade
//rotas ACL Regras
Route::get('/roles', [RolesController::class, 'index']); // http://127.0.0.1:8000/api/roles/ , rota listar regras de usuario
Route::get('/roles/{roles}', [RolesController::class, 'show']); // http://127.0.0.1:8000/api/roles/{abilities} , rota listar regra especifica
Route::post('/roles', [RolesController::class, 'store']); // http://127.0.0.1:8000/api/roles/ , rota criar regra de usuario
Route::put('/roles/{roles}', [RolesController::class, 'update']); // http://127.0.0.1:8000/api/roles/{abilities} , rota de editar regra de usuario especifica
Route::delete('/roles/{roles}', [RolesController::class, 'destroy']); // http://127.0.0.1:8000/api/roles/{abilities} , rota excluir regra de usuario
//rotas ACL Habilidades de usuario
Route::get('/abilitiesUser', [AbilityUserController::class, 'index']); // http://127.0.0.1:8000/api/abilities-users/ , rota listar habilidades de usuario que eles pertecen 
Route::get('/abilitiesUser/{abilityUser}', [AbilityUserController::class, 'show']); // http://127.0.0.1:8000/api/abilities-user/{abilities-users} , rota listar habilidades de usuario especifico que eles pertecen 
Route::post('/abilitiesUser', [AbilityUserController::class, 'store']); // http://127.0.0.1:8000/api/abilities-users/ rotas para adicionar habilidades de usuarios
Route::put('/abilitiesUser/{abilityUser}', [AbilityUserController::class, 'update']); // http://127.0.0.1:8000/api/abilities-users/{abilities-users} rota para editar habilidades do usuario
Route::delete('/abilitiesUser/{abilityUser}', [AbilityUserController::class, 'destroy']); // http://127.0.0.1:8000/api/abilities-users/ {abilities-users}  rota para excluir usuario
//rotas ACL Regras de usuario
Route::get('/rolesUsers', [RoleUserController::class, 'index']); // http://127.0.0.1:8000/api/rolesUsers retorna lista dos usuarios com sua regra
Route::get('/rolesUsers/{rolesUser}', [RoleUserController::class, 'show']); // http://127.0.0.1:8000/api/rolesUsers/{rolesUsers} retorna  usuarios especifico com sua regra
Route::post('/rolesUsers', [RoleUserController::class, 'store']); // http://127.0.0.1:8000/api/rolesUsers cria regra a um usuario especifico
Route::put('/rolesUsers/{rolesUser}', [RoleUserController::class, 'update']); // http://127.0.0.1:8000/api/rolesUsers/{rolesUsers} editar a regra de um usuario
Route::delete('/rolesUsers/{rolesUser}', [RoleUserController::class, 'destroy']); // http://127.0.0.1:8000/api/rolesUsers/{rolesUsers} exclui regra de um usuario
//rotas ACL Habilidades da regra de usuario
Route::get('/abilitiyRole', [abilityRoleController::class, 'index']); // http://127.0.0.1:8000/api/abilitiyRole retorna lista da regra e suas habilidades
Route::get('/abilitiyRole/{abilityRole}', [abilityRoleController::class, 'show']); // http://127.0.0.1:8000/api/abilitiyRole/{abilitiyRole} retorna regra e suas habilidades
Route::post('/abilitiyRole', [abilityRoleController::class, 'store']); // http://127.0.0.1:8000/api/abilitiyRole/{abilitiyRole} api para adicionar uma habilidade a regra
Route::put('/abilitiyRole/{abilityRole}', [abilityRoleController::class, 'update']); // http://127.0.0.1:8000/api/abilitiyRole/{abilitiyRole} api para editar uma habilidade a regra
Route::delete('/abilitiyRole/{abilityRole}', [abilityRoleController::class, 'destroy']); // http://127.0.0.1:8000/api/abilitiyRole/{abilitiyRole} api para editar uma habilidade a regra
//route Empresas 
Route::get('/empresas', [EmpresasController::class, 'index']); // http://127.0.0.1:8000/api/empresas listar empresas
Route::get('/empresas/{empresas}', [EmpresasController::class, 'show']); // http://127.0.0.1:8000/api/empresas/{empresas} listar empresas especifica

//contato Empresa
Route::post('/contato/empresa', [ContatoEmpresaController::class, 'store']);
Route::get('/contato/empresa', [ContatoEmpresaController::class, 'index']);
Route::get('/contato/empresa/{contatoEmpresa}', [ContatoEmpresaController::class, 'show']);
Route::delete('/contatos/empresa/{contatos}', [ContatosController::class, 'destroy']);
Route::put('/contatos/empresa/{contatos}', [ContatosController::class, 'update']);
// rotas que sao necessarios os tokens de autenticacao 
Route::post('/logout/{user}', [LoginController::class, 'logout'])->name('logout'); //rota de logout do usuario
route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users', [UserController::class, 'index']); //get http://127.0.0.1:8000/api/users?page=1 exibe conteudo de  todos os usuarios 

    //rotas endereco
    Route::get('/endereco', [EnderecoController::class, 'index']); //get http://127.0.0.1:8000/api/endereco/1 Exibe todos os endereco 
    Route::get('/endereco/{endereco}', [EnderecoController::class, 'show']); //get http://127.0.0.1:8000/api/endereco/{endereco} exibe endereco do Id solicitado
    Route::post('/endereco', [EnderecoController::class, 'store']); //get http://127.0.0.1:8000/api/endereco/ Cria um endereco
    Route::put('/endereco/{endereco}', [EnderecoController::class, 'update']); //get http://127.0.0.1:8000/api/endereco/{{endereco}} edita um endereco solicitado 
    Route::delete('/endereco/{endereco}', [EnderecoController::class, 'destroy']); //get http://127.0.0.1:8000/api/endereco/{{endereco}} Exclui um endereco solicitado

    //rotas do genero
    Route::get('/genero', [GeneroController::class, 'index'])->name('genero'); //get http://127.0.0.1:8000/api/genero/ , exibe conteudo dos generos cadastrados
    Route::post('/genero', [GeneroController::class, 'store']); //post http://127.0.0.1:8000/api/genero/ , cria um genero
    Route::put('/genero/{genero}', [GeneroController::class, 'update']); //post http://127.0.0.1:8000/api/genero/{genero} edit
    Route::get('/genero/{genero}', [GeneroController::class, 'show']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado
    Route::delete('/genero/{genero}', [GeneroController::class, 'destroy']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado
    //contatos
    Route::post('/contatos', [ContatosController::class, 'store']);
    Route::get('/contatos', [ContatosController::class, 'index']);
    Route::get('/contatos/{contatos}', [ContatosController::class, 'show']);
    Route::delete('/contatos/{contatos}', [ContatosController::class, 'destroy']);
    Route::put('/contatos/{contatos}', [ContatosController::class, 'update']);

    //empresa
    Route::post('/empresas', [EmpresasController::class, 'store']);
});
