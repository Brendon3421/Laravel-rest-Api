<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneroRequest;
use App\Models\Genero;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $genero = Genero::orderby('id', 'DESC')->paginate(3);
        // retorna os usuarios recuperados com uma resposta em JSON
        return response()->json([
            'status' => true,
            'genero' => $genero,
        ], 200);
    }

    public function store(GeneroRequest $request): JsonResponse
    {
        try {
            $genero = Genero::create($request->validated());
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

    public function update(GeneroRequest $request, Genero $genero): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Atualiza o gênero com sucesso
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


    public function show(Genero $genero): JsonResponse
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

    public function destroy(Genero $genero)
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
