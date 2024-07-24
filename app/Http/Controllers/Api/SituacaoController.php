<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SituacaoRequest;
use App\Models\Situacao;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class SituacaoController extends Controller
{


    //retorna todas as situacao 
    public function index(): JsonResponse
    {

        $situacao = Situacao::orderby('ID', 'DESC')->paginate(3);
        return response()->json([
            'status' => true,
            'situacao' => $situacao,
            "message" => "Situacoes retornandas com sucesso"
        ], 200);
    }


    //retorna situacao solicitada pelo Id da Url
    public function show(Situacao $situacao): JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'Situacao' => $situacao,
                'message' => "situacao listada com sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Situacao  Nao encotrada'
            ], 404);
        }
    }

    //criar uma situacao
    public function store(SituacaoRequest $request): JsonResponse
    {
        try {
            //inicia trasnsicao da api
            DB::beginTransaction();
            //criar a situacao e passa pelas validacao
            $situacao =  Situacao::create($request->validated());
            DB::commit();
            return response()->json([
                'status' => true,
                'situacao' => $situacao,
                'Message' => 'Usuario cadastrado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'Message' => ' Nao foi possivel cadastrar'
            ], 400);
        }
    }
    //method de editar situacao
    public function update(SituacaoRequest $request, Situacao $situacao): JsonResponse
    {
        try {
            // Inicia a transação da API
            DB::beginTransaction();
            // Atualiza os dados do modelo existente
            $situacao->update($request->validated());
            DB::commit();
            return response()->json([
                'status' => true,
                'situacao' => $situacao,
                'message' => 'Situação atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível atualizar a situação'
            ], 400);
        }
    }
    //deleta a situacao 
    public function destroy(Situacao $situacao): JsonResponse
    {
        try {
            DB::beginTransaction();
            $situacao->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'Situacao deletada' => $situacao,
                'message' => 'Situacao deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Nao foi possivel deletar essa situacao',
            ], 400);
        }
    }
}
