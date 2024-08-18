<?php

namespace App\Services;

use App\DTOs\ContatosDTO;
use App\Http\Requests\ContatosUserRequest;
use App\Models\contatosUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContatosServices
{

    public function listarContatos(): JsonResponse
    {
        try {
            $contato = contatosUser::with(['user'])->orderby('ID', 'DESC')->paginate(3);
            $contatosDTO = $contato->map(function ($contato) {
                return ContatosDTO::fromModel($contato);
            });
            return response()->json([
                'status' => true,
                'contatos' => $contatosDTO,
                'message' => 'Contatos listados com sucesso',
                'pagination' => [
                    'total' => $contato->total(),
                    'count' => $contato->count(),
                    'per_page' => $contato->perPage(),
                    'current_page' => $contato->currentPage(),
                    'total_pages' => $contato->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'message' => 'Falha ao listar contatos',
            ], 400);
        }
    }

    public function listarContatosId(contatosUser $contatos): JsonResponse
    {
        try {
            $contatos->load(['user']);
            $contatosDTO = ContatosDTO::fromModel($contatos);

            return response()->json([
                'status' => true,
                'Contatos' => $contatosDTO,
                'message' => 'Contato listado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'message' => 'Falha ao listar contato'
            ], 400);
        }
    }

    public function criarContatos(ContatosUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            // Obter o ID do usuário autenticado
            $user_id = auth()->id();
            $contatosDTO = ContatosDTO::makeFromModel($request, $user_id);
            $contatosArray = $contatosDTO->toArray();
            $contato = ContatosUser::create($contatosArray);
            DB::commit();
            return response()->json([
                'status' => true,
                'contato' => $contato,
                'message' => 'Contato foi criado com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'error' => 'Falha ao criar contato'
            ], 400);
        }
    }


    public function editarContatos(ContatosUserRequest $request, contatosUser $contatos)
    {
        try {
            DB::beginTransaction();
            $contatos->fill($request->validated());
            $contatos->save();
            $contatosDTO = ContatosDTO::makeFromModel($request, $contatos->user_id);
            DB::commit();
            return response()->json([
                'status' => true,
                'endereco' => $contatosDTO->toArray(),
                'message' => 'Contato atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao atualizar contato'
            ], 400);
        }
    }


    public function excluirContatoUser(contatosUser $contatos): JsonResponse
    {
        try {
            DB::beginTransaction();
            $contatos->delete();
            $contatosDTO = ContatosDTO::fromModel($contatos)->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'contatos' => $contatos,
                'sucess' => "Contato deletado com sucesso",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'error' => "Nao foi possivel deletar",
            ], 400);
        }
    }
}
