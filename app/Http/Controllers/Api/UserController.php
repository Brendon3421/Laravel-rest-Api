<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mockery\Expectation;

class UserController extends Controller
{

    public $usuario;

    public function __construct()
    {
    }

    public function genero()
    {
  
    }


    public function index(): JsonResponse
    {
        // recuperar os dados do bando pelo Id em ordem decrescente e faz a paginacao de no maximo 3 por pagina 
        $users = User::orderby('id', 'DESC')->paginate(3);
        // retorna os usuarios recuperados com uma resposta em JSON
        return response()->json([
            'status' => true,
            'users' => $users,
        ], 200);
    }

    // : JsonResponse Tipagem da API
    public function show(User $user): JsonResponse
    {
        //retorna o o usuario que passar o id na url
        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
    }


    public function store(UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = User::create($request->validated());
            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário cadastrado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar usuário'
            ], 400);
        }
    }


    public function update(UserRequest $request, User $user): JsonResponse
    {
        // iniciar a transacao
        DB::beginTransaction();
        try {
            // editar
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuario editado com sucesso"
            ]);
        } catch (Exception $e) {
            // Operacao de erro 
            DB::rollBack();
            // deve retorna uma mensagem de erro status 400     
            return response()->json([
                'status' => false,
                "message" => "Usuario nao editado"
            ], 400);
        }
        return response()->json([
            'status' => true,
            'user' => $user,
            "message" => "Editado com sucesso"
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Apagar o usuário do banco de dados
            $user->delete();
            // Confirmar a transação
            DB::commit();
            // Retorna se apagou com sucesso
            return response()->json([
                'status' => true,
                'message' => "Usuário excluído com sucesso"
            ], 200);
        } catch (Exception $e) {
            // Reverter a transação em caso de erro
            DB::rollBack();
            // Retorna a mensagem de erro
            return response()->json([
                'status' => false,
                'message' => "Ocorreu um erro durante o processo de exclusão",
                'error' => $e->getMessage() // Opcional: Adicionar a mensagem de erro para depuração
            ], 400);
        }
    }
}
