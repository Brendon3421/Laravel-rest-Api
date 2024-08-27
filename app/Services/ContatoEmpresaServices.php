<?php

namespace App\Services;

use App\DTOs\ContatoEmpresaDTO;
use App\Http\Requests\ContatoEmpresaRequest;
use App\Models\ContatoEmpresa;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContatoEmpresaServices
{

    public function listarContatos(): JsonResponse
    {
        try {
            $contatoEmpresa = ContatoEmpresa::with(['empresa'])->orderby('ID', 'DESC')->paginate(3);
            $contatosEmpresaDTO = $contatoEmpresa->map(function ($contato) {
                return ContatoEmpresaDTO::fromModel($contato);
            });
            return response()->json([
                'status' => true,
                'contatos' => $contatosEmpresaDTO,
                'message' => 'Contatos listados com sucesso',
                'pagination' => [
                    'total' => $contatoEmpresa->total(),
                    'count' => $contatoEmpresa->count(),
                    'per_page' => $contatoEmpresa->perPage(),
                    'current_page' => $contatoEmpresa->currentPage(),
                    'total_pages' => $contatoEmpresa->lastPage()
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

    public function listarContatosId(ContatoEmpresa $contatoEmpresa): JsonResponse
    {
        try {
            exit;
            $contatoEmpresa->load(['empresa']);
            $contatosDTO = ContatoEmpresaDTO::fromModel($contatoEmpresa);

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

    public function criarContatos(ContatoEmpresaRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            // Obter o ID do usuário autenticado
            $empresa_id = $request->empresa_id;
            $sub_empresa_id = $request->sub_empresa_id ?: null;
            $contatosDTO = ContatoEmpresaDTO::makeFromModel($request, $empresa_id, $sub_empresa_id);
            $contatosArray = $contatosDTO->toArray();
            $contato = ContatoEmpresa::create($contatosArray);
            DB::commit();

            return response()->json([
                'status' => true,
                'contato' => $contato,
                'message' => 'Contato foi criado com sucesso',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => true,
                'message' => "erro na validacao",
                'error' => $e->getMessage(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'error' => 'Falha ao criar contato'
            ], 400);
        }
    }


    public function editarContatos(ContatoEmpresaRequest $request, ContatoEmpresa $contatoEmpresa)
    {
        try {
            DB::beginTransaction();
            $contatoEmpresa->fill($request->validated());
            $contatoEmpresa->save();
            $contatoEmpresaDTO = ContatoEmpresaDTO::makeFromModel($request, $contatoEmpresa->empresa_id, $contatoEmpresa->sub_empresa_id);
            $contatoEmpresaDTO->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'endereco' => $contatoEmpresaDTO,
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


    public function excluirContatoUser(ContatoEmpresa $contatoEmpresa): JsonResponse
    {
        try {
            DB::beginTransaction();
            $contatoEmpresa->delete();
            $contatoEmpresaDTO = ContatoEmpresaDTO::fromModel($contatoEmpresa)->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'contatos' => $contatoEmpresaDTO,
                'sucess' => "Contato da Empresa deletado com sucesso",
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
