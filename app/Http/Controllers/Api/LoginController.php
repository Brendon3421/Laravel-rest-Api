<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Expectation;

class LoginController extends Controller
{


    public function __construct()
    {
    }
    /* essa e o metodo responsavel pela autenticacao do usuario caso der certo ele demonstra o token e as informacoes
do usuario que foi solicitado mas se der errado ele da uma mensagem falha de login ou senha incorreta

*/
    public function auth(Request $request): JsonResponse
    {
        // validar o email e senha 
        if (Auth::attempt([
            'email' => $request->email, 'password' => $request->password
        ])) {

            //recupera os dados do usuario 
            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

            //retorna o status de sucesso
            return response()->json([
                'status' => true,
                'token' => $token,
                'Usuario' => $user,
                'message' => "Logado com sucesso",
            ], 201);
        } else {
            // retorna que deu erro durante o processo de login
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta',
            ], 404);
        }
    }
    // realiza o logout do usuario 
    public function logout(User $user): JsonResponse
    {
        try {
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'nome do usuario' => $user->name,
                'message' => 'usuario foi desconectado com sucesso',
            ], 200);

        } catch (Exception $e) {
    return response()->json([
                'status' => false,
                'message' => 'usuario nao foi desconectado ',
            ], 400);
        }
    }
}
