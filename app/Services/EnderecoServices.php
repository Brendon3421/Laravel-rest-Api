<?php

namespace App\Services;

use App\DTOs\EnderecoDTO;
use App\Http\Requests\EnderecoRequest;
use App\Models\Empresas;
use App\Models\Endereco;
use Exception;
use Illuminate\Support\Facades\DB;
use Dotenv\Exception\ValidationException;

class EnderecoServices
{
    public function listarEndereco()
    {
        try {
            $enderecos = Endereco::with(['user', 'empresas', 'situacao'])->orderBy('id', 'DESC')->paginate(3);
            $enderecoData = $enderecos->map(function ($endereco) {
                return EnderecoDTO::fromModel($endereco)->toArray();
            });
            return response()->json([
                'status' => true,
                'endereco' => $enderecoData,
                'message' => 'Endereços listados com sucesso',
                'pagination' => [
                    'total' => $enderecos->total(),
                    'count' => $enderecos->count(),
                    'per_page' => $enderecos->perPage(),
                    'current_page' => $enderecos->currentPage(),
                    'total_pages' => $enderecos->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Falha ao listar endereços',
            ], 400);
        }
    }

    public function ListarEnderecoId(Endereco $endereco)
    {
        try {
            $endereco->load(['user', 'situacao']);
            $enderecoDTO = EnderecoDTO::fromModel($endereco);

            return response()->json([
                'status' => true,
                'Endereco' => $enderecoDTO->toArray(),
                'message' => "Endereço listado com sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage()
            ], 400);
        }
    }

    public function criarEndereco(EnderecoRequest $request,)
    {
        try {
            DB::beginTransaction();
            $userId = auth()->id();
            dd($userId);
            $empresas = $request->empresa_id;
            $enderecoDTO = EnderecoDTO::makeFromRequest($request, $userId, $empresas);
            $enderecoData = $enderecoDTO->toArray();
            $enderecoData['user_id'] = $userId;
            $endereco = Endereco::create($enderecoData);



            DB::commit();
            return response()->json([
                'status' => true,
                'Endereco' => $endereco,
                'message' => 'Endereço cadastrado com sucesso'
            ], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => "error na validacao",
                'validacao' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Erro ao cadastrar endereço'
            ], 400);
        }
    }

    public function editarEndereco(EnderecoRequest $request, Endereco $endereco, Empresas $empresas)
    {
        try {
            DB::beginTransaction();
            // Preenche o objeto $endereco com os dados validados do request
            $endereco->fill($request->validated());
            $endereco->save();
            // Atualize o EnderecoDTO com base no endereço existente
            $empresas = $empresas->id;
            $enderecoDTO = EnderecoDTO::fromModel($endereco, $endereco->user_id, $empresas);
            DB::commit();
            return response()->json([
                'status' => true,
                'endereco' => $enderecoDTO,
                'message' => 'Endereço atualizado com sucesso'
            ], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => "Erro na validação",
                'validacao' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao atualizar endereço'
            ], 400);
        }
    }


    public function excluirEndereco(Endereco $endereco)
    {
        try {
            DB::beginTransaction();
            $endereco->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'Endereco' => $endereco,
                'message' => "Endereço excluído com sucesso"
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao excluir Endereço'
            ], 400);
        }
    }
} 
// 