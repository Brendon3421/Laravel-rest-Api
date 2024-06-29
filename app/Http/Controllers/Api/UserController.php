<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Expectation;

class UserController extends Controller
{

    public $usuario;

    public function __construct()
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
        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
    }

    public function store(UserRequest $request): JsonResponse
    {

        DB::beginTransaction();

        try {
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            // quando ele commitar/enviar para o banco`-`
            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                "message" => "ele deu certo xara"
            ], 201);
        } catch (Exception $e) {
            // Operacao de erro 
            DB::rollBack();
            // deve retorna uma mensagem de erro status 400     
            return response()->json([
                'status' => false,
                "message" => "fudeu essa bomba e num cadastro "
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


        try {
            // apagar o usuario do banco de dados
            $user->delete();
            // retorna se apagou com sucesso
            return response()->json([
                'status' => true,
                'message' => "usuario excluido com sucesso"
            ], 200);
        } catch (Exception $e) {
            //operacao de erro
            DB::rollBack();
            //retorna
            return response()->json([
                'status' => false,
                'message' => "Ocorreu um erro durante o processo de excluir "
            ], 400);
        }
    }
}
