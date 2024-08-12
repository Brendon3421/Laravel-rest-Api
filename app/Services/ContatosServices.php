<?php

namespace App\Services;

use App\DTOs\ContatosDTO;
use App\Http\Requests\ContatosRequest;
use App\Models\Contatos;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContatosServices
{

    public function listarContatos(): JsonResponse
    {
        try {
            $contato = Contatos::with(['user', 'empresa'])->orderby('ID', 'DESC')->paginate(3);
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

    public function listarContatosId(Contatos $contatos): JsonResponse
    {
        try {
            $contatos->load(['user', 'empresa']);
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

    public function criarContatos(ContatosRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $user_id = $user->id;
            $empresa_id = $user->empresa_id;

            // Valida e obtém os dados do request
            $validatedData = $request->validated();

            // Adiciona user_id e empresa_id aos dados
            $validatedData['user_id'] = $user_id;
            $validatedData['empresa_id'] = $empresa_id;

            // Cria um DTO a partir dos dados validados
            $contatosDTO = ContatosDTO::MakefromModel($validatedData,$user_id,$empresa_id);

            // Cria o contato no banco de dados
            $contato = Contatos::create($contatosDTO->toArray());

            // Obtém o DTO do contato recém-criado
            $contatoDTO = ContatosDTO::fromModel($contato);

            DB::commit();

            return response()->json([
                'status' => true,
                'contato' => $contatoDTO,
                'message' => 'Contato criado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'message' => 'Falha ao criar contato',
            ], 400);
        }
    }
}
