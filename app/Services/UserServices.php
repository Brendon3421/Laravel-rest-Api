<?php

namespace App\Services;

use App\DTOs\ContatosDTO;
use App\DTOs\EnderecoDTO;
use App\DTOs\UserDTO;
use App\Http\Requests\ContatosUserRequest;
use App\Models\User;
use App\Http\Requests\EnderecoRequest;
use App\Http\Requests\UserRequest;
use App\Models\contatosUser;
use App\Models\Endereco;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;

class UserServices
{
    public function listarUsuarios()
    {
        try {
            // Recuperar os dados do banco pelo Id em ordem decrescente e faz a paginação de no máximo 3 por página
            $users = User::with(['empresa', 'situacao', 'genero'])->orderBy('ID', 'DESC')->paginate(3);

            // Mapear os modelos para DTOs
            $userData = $users->map(function ($user) {
                return UserDTO::fromModel($user)->toArray();
            });

            return response()->json([
                'status' => true,
                'usuarios' => $userData,
                'message' => 'Usuários listados com sucesso',
                'pagination' => [
                    'total' => $users->total(),
                    'count' => $users->count(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'total_pages' => $users->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Falha ao listar usuários',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function listarUSerEspecifico(User $user)
    {
        try {
            // Carregar as relações situacao e genero
            $user->load(['empresa', 'situacao', 'genero']);
            $userDTO = UserDTO::fromModel($user);
            // Preparar os dados do usuário para a resposta JSON
            return response()->json([
                'status' => true,
                'usuario' => $userDTO->toArray(),
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

    public function criarUsuario(
        UserRequest $request,
        EnderecoRequest $enderecoRequest,
        ContatosUserRequest $contatosUserRequest
    ) {
        try {
            DB::beginTransaction();

            // Validar os dados do usuário e criar o DTO
            $userDTO = UserDTO::fromModelCreate($request->validated());
            $user = User::create($userDTO->toArray());
            // Validar os dados de endereço e criar o DTO
            $empresas_id = null;
            $enderecoDTO = EnderecoDTO::makeFromRequest($enderecoRequest, $user->id, $empresas_id);
            $enderecoData = $enderecoDTO->toArray();
            $enderecoData['user_id'] = $user->id;
            $endereco = Endereco::create($enderecoData);

            // Validar os dados de contato e criar o DTO
            $contatosDTO = ContatosDTO::makeFromModel($contatosUserRequest, $user->id);
            $contatosArray = $contatosDTO->toArray();
            $contato = ContatosUser::create($contatosArray);

            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'endereco' => $endereco,
                'contato' => $contato,
                'message' => 'Usuário cadastrado com sucesso'
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro de validação',
                'errors' => $e->getMessage() // Retorna erros de validação específicos
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar usuário',
                'error' => $e->getMessage()
            ], 500); // Código 500 para erros internos do servidor
        }
    }

    public function editarUsuario(User $user, UserRequest $request, EnderecoRequest $enderecoRequest, contatosUser $contatosRequest)
    {
        DB::beginTransaction();
        try {
            // Atualizar os dados do usuário
            $userDTO = UserDTO::fromModelRequest($user, $request);
            $user->fill($userDTO->toArray());
            $user->save();

            // Atualizar ou criar o endereço
            $endereco = Endereco::where('user_id', $user->id)->first();

            if ($endereco) {
                $enderecoDTO = EnderecoDTO::makeFromRequest($enderecoRequest, $user->id, $user->empresa_id);
                $endereco->fill($enderecoDTO->toArray());
                $endereco->save();
            } else {
                $enderecoDTO = EnderecoDTO::makeFromRequest($enderecoRequest, $user->id, $user->empresa_id);
                $endereco = new Endereco($enderecoDTO->toArray());
                $endereco->user_id = $user->id;
                $endereco->save();
            }

            // Atualizar ou criar o contato
            $contato = contatosUser::where('user_id', $user->id)->first();

            if ($contato) {
                $contatoDTO = ContatosDTO::updatefromModel($contatosRequest, $user->id);
                $contato->fill($contatoDTO->toArray());
                $contato->save();
            } else {
                $contatoDTO = ContatosDTO::updatefromModel($contatosRequest, $user->id);
                $contato = new contatosUser($contatoDTO->toArray());
                $contato->user_id = $user->id;
                $contato->save();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'endereco' => $endereco,
                'contato' => $contato,
                'message' => "Usuário editado com sucesso"
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Usuário não editado",
                'error' => $e->getMessage()
            ], 400);
        }
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
