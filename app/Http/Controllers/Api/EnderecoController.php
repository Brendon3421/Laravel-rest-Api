<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{

    //funcao de listar dos os endereco em ordem descrescente
    public function index(): JsonResponse
    {
        $endereco = Endereco::orderby('id', 'DESC')->paginate(3);
        return response()->json([
            'status' => true,
            'endereco' => $endereco
        ], 200);
    }
    //funcao de mostrar endereco com ID especifico 
    public function show(Endereco $endereco): JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'Endereco' => $endereco,
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
    public function store(EnderecoRequest $request) : JsonResponse
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
    public function update(EnderecoRequest $request, Endereco $endereco) : JsonResponse
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
    public function destroy(Endereco $endereco){

        try{
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
            ],200);
        } catch (Exception $e){
            DB::rollBack();
            return response([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao excluir Endereco'
            ],400);
        }

    }

}
