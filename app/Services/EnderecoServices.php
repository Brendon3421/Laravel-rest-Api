<?php

namespace App\Services;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use Exception;
use Illuminate\Support\Facades\DB;

class EnderecoServices{

    public function listarEdendereco()
    {
        try {
            $endereco = Endereco::with(['user', 'situacao'])->orderBy('id', 'DESC')->paginate(3);
            DB::beginTransaction();
            $enderecoData = $endereco->map(function ($enderecos) {
                return [
                    'id' => $enderecos->id,
                    'Nome do Usuario' => $enderecos->user->name ?? 'Usuario nao encontrado',
                    'Situacao' => $enderecos->situacao->name   ?? 'Situacao nao encotrado',
                    'name' => $enderecos->name,
                    'cep' => $enderecos->cep,
                    'rua' => $enderecos->rua,
                    'numero' => $enderecos->numero,
                    'complemento' => $enderecos->complemento,
                    'ip_address' => $enderecos->ip_address,
                    'created_at' => $enderecos->created_at,
                    'updated_at' => $enderecos->updated_at,
                ];
            });

            return response()->json([
                'status' => true,
                'endereco' => $enderecoData,
                'message' => 'Endereco listado com sucesso',
                'pagination' => [
                    'total' => $endereco->total(),
                    'count' => $endereco->count(),
                    'per_page' => $endereco->perPage(),
                    'current_page' => $endereco->currentPage(),
                    'total_pages' => $endereco->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => False,
                'endereco' => $enderecoData,
                'message' => 'Falha ao listar endereco',
                'pagination' => [
                    'total' => $endereco->total(),
                    'count' => $endereco->count(),
                    'per_page' => $endereco->perPage(),
                    'current_page' => $endereco->currentPage(),
                    'total_pages' => $endereco->lastPage()
                ]
            ], 400);
        }
    }
    //funcao de mostrar endereco com ID especifico 
    public function ListarEnderecoId(Endereco $endereco)
    {
        try {

            $endereco->load(['user']);

            $enderecoData = [
                'id' => $endereco->id,
                'Nome do Usuario' => $endereco->user->name ?? 'Usuario nao encontrado',
                'Situacao' => $endereco->situacao->name   ?? 'Situacao nao encotrado',
                'name' => $endereco->name,
                'cep' => $endereco->cep,
                'rua' => $endereco->rua,
                'numero' => $endereco->numero,
                'complemento' => $endereco->complemento,
                'ip_address' => $endereco->ip_address,
                'created_at' => $endereco->created_at,
                'updated_at' => $endereco->updated_at,
            ];
            return response()->json([
                'status' => true,
                'Endereco' => $enderecoData,
                'message' => "Endereco listado com sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage()
            ], 400);
        }
    }
    //criar endereco
    public function criarEndereco(EnderecoRequest $request)
    {
        try {
            DB::beginTransaction();
            // Obtém o ID do usuário autenticado
            $userId = auth()->id();
            // Cria um novo endereço com os dados validados e o ID do usuário
            $endereco = Endereco::create(array_merge(
                $request->validated(),
                ['user_id' => $userId] // Adiciona o ID do usuário ao array de dados
            ));
            DB::commit();
            return response()->json([
                'status' => true,
                'Endereco' => $endereco,
                'message' => 'Endereço cadastrado com sucesso'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Erro ao cadastrar endereço'
            ], 400);
        }
    }
    //Editar Endereco
    public function editarEndereco(EnderecoRequest $request, Endereco $endereco)
    {
        try {
            // Inicia a transação
            DB::beginTransaction();
            // Obtém o ID do usuário autenticado
            $userId = auth()->id();
            // Atualiza o endereço com os dados validados e o ID do usuário autenticado
            $endereco->update(array_merge(
                $request->validated(), // Dados validados
                ['user_id' => $userId]  // Adiciona o ID do usuário
            ));
            // Confirma a transação
            DB::commit();
            return response()->json([
                'status' => true,
                'Endereco Atualizado' => $endereco,
                'message' => 'Endereço atualizado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            // Reverte a transação se algo der errado
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao atualizar o endereço.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function excluirEndereco(Endereco $endereco)
    {
        try {
            // inicia transacao da api
            DB::beginTransaction();
            //deletetando o endereco 
            $endereco->delete();
            // confirmando o delete do endereco 
            DB::commit();
            return response()->json([
                'status' => true,
                'Endereco' => $endereco,
                'message' => "Endereco excluido com sucesso"
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao excluir Endereco'
            ], 400);
        }
    }


}
