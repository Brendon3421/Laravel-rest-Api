<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session;
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
    //retorna a view de login
    public function authView()
    {
        return view('login');
    }
    //retorna a view de regiter
    public function authRegister()
    {
        return view('registrarUser');
    }


    public function auth(Request $request): JsonResponse
    {
        // Validar o email e senha
        if (Auth::attempt([
            'email' => $request->email, 'password' => $request->password
        ])) {
            // Recupera os dados do usuário autenticado
            $user = Auth::user();

            // Criar um token para o usuário (exemplo de uso de tokens API)
            $token = $request->user()->createToken('api-token')->plainTextToken;

            // Retorna uma resposta JSON de sucesso com o token e informações do usuário
            return response()->json([
                'status' => true,
                'token' => $token,
                'Usuario' => $user,
                'message' => "Logado com sucesso",
            ], 201);
        } else {
            // Retorna uma resposta JSON de erro se o login falhar
            // Aqui você redireciona de volta para a tela de login
            return response()->json([
                'status' => false,
                'error' => 'Login ou senha incorreta',
            ], 404);
        }
    }
    // realiza o logout do usuario 
    public function logout(User $user): JsonResponse
    {
        try {
            Auth::logout();
            Session::flush();

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
