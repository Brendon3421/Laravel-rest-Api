<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\EnderecoRequest;
use App\Http\Requests\UserRequest;
use App\Models\Endereco;
use Exception;
use Illuminate\Support\Facades\DB;

class UserServices
{

public function listarUsuarios()
{
    try {
        $user = User::with(['situacao', 'genero'])->orderby('ID', 'DESC')->paginate(3);
        // recuperar os dados do bando pelo Id em ordem decrescente e faz a paginacao de no maximo 3 por pagina 
        $userData = $user->map(function ($usuario) {
            return [
                "id" => $usuario->id,
                "name" => $usuario->name,
                "email" => $usuario->email,
                "email_verified_at" => $usuario->email_verified_at,
                "genero_id" => $usuario->genero->name ?? "genero nao encontrado",
                "situacao_id" => $usuario->situacao->name ?? "situacao nao encontrado",
                "created_at" => $usuario->created_at,
                "updated_at" => $usuario->updated_at
            ];
        });

        return response()->json([
            'status' => true,
            'usuarios' => $userData,
            'message' => 'Usuarios listado com sucesso',
            'pagination' => [
                'total' => $user->total(),
                'count' => $user->count(),
                'per_page' => $user->perPage(),
                'current_page' => $user->currentPage(),
                'total_pages' => $user->lastPage()
            ]
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'usuarios' => $userData,
            'message' => 'Falha ao listar usuario',
            'error' => $e->getMessage()
        ], 400);
    }
}


    public function listarUSerEspecifico(User $user)
    {
        try {
            // Carregar as relações situacao e genero
            $user->load(['situacao', 'genero']);

            // Preparar os dados do usuário para a resposta JSON
            $userData = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "email_verified_at" => $user->email_verified_at,
                "genero_id" => $user->genero->name ?? "genero nao encontrado",
                "situacao_id" => $user->situacao->name ?? "situacao nao encontrado",
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at
            ];

            return response()->json([
                'status' => true,
                'usuario' => $userData,
                'message' => 'Usuario listado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Falha ao listar usuario',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function criarUsuario(UserRequest $request , EnderecoRequest $enderecoRequest)
    {
        try {
            DB::beginTransaction();
            //cria o usuario
            $user = User::create($request->validated());

            //cria o endereco
            $enderecoData = $enderecoRequest->validated();
            $enderecoData['user_id'] = $user->id;
            $endereco = Endereco::create($enderecoData);

            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'Endereco' => $endereco,
                'message' => 'Usuário cadastrado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar usuário',
                'error' =>  $e->getMessage()
            ], 400);
        }
    }

    public function editarUsuario(User $user, UserRequest $request)
    {
           // iniciar a transacao
           DB::beginTransaction();
           try {
               // editar
               $user->update($request->validated());
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

    public function destroy(User $user)
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
