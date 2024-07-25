<?php


namespace App\Services;

use App\Http\Requests\GeneroRequest;
use App\Models\Genero as modelGenero;
use Exception;
use Illuminate\Support\Facades\DB;

class GeneroServices
{
    public function listarGenero()
    {
        $genero = modelGenero::orderby('id', 'DESC')->paginate(3);
        // retorna os usuarios recuperados com uma resposta em JSON
        return response()->json([
            'status' => true,
            'genero' => $genero,
        ], 200);
    }
    public function listarGeneroId(modelGenero $genero)
    {
        try {
            return response()->json(
                [
                    'status' => true,
                    'name' => $genero->name,
                    'message' => 'Usuario listado com sucesso'
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
            ], 400);
        }
    }
    public function criarGenero(GeneroRequest $request)
    {
        try {
            $genero = modelGenero::create($request->validated());
            return response()->json([
                'status' => true,
                'genero' => $genero,
                'message' => 'Gênero criado com sucesso',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar gênero',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function editarGeneroid(modelGenero $genero, GeneroRequest $request)
    {
        try {
            // Atualiza o gênero com sucesso
            DB::beginTransaction();
            $genero->update($request->validated());
            DB::commit();
            return response()->json([
                'status' => true,
                'genero' => $genero,
                'message' => "Genero editado com sucesso",
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Nao foi possivel editar",
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function excluirGenero(modelGenero $genero)
    {
        try {
            //pegar o genero que sera excluido
            $genero->delete();
            return response()->json([
                'status' => true,
                'Nome do genero' => $genero->name,
                'message' => "genero Excluido com sucesso"
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}