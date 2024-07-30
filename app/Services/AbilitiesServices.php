<?php
namespace App\Services;

use App\DTOs\AbilitiesDTO;
use App\Http\Requests\AbilitiesRequest;
use App\Models\Abilities;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbilitiesServices
{
    public function listarAbilities(): JsonResponse
    {
        try {
            $abilities = Abilities::orderBy('id', 'DESC')->paginate(3);
            $abilitiesDTO = AbilitiesDTO::fromCollection($abilities->getCollection())->map(function ($abilityDTO) {
                $abilityDTO->name = strtoupper($abilityDTO->name);
                return $abilityDTO;
            });

            return response()->json([
                'status' => true,
                'Habilidades' => $abilitiesDTO,
                'message' => 'Habilidades listadas com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Não foi possível listar as habilidades',
            ], 400);
        }
    }

    public function listarAbilitiesId(Abilities $ability): JsonResponse
    {
        try {
            $abilitiesDTO = AbilitiesDTO::fromModel($ability);

            return response()->json([
                'status' => true,
                'Habilidade' => $abilitiesDTO,
                'message' => 'Habilidade listada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível listar a habilidade',
            ], 400);
        }
    }

    public function criarAbilities(AbilitiesRequest $request): JsonResponse
    {
        try {
            $ability = Abilities::create($request->validated());
            $abilitiesDTO = AbilitiesDTO::makefromModel($ability);

            return response()->json([
                'status' => true,
                'Habilidade' => $abilitiesDTO,
                'message' => 'Habilidade criada com sucesso'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível criar a habilidade',
            ], 400);
        }
    }

    public function editarAbilitiesId(AbilitiesRequest $request, Abilities $ability): JsonResponse
    {
        try {
           $ability->update($request->validated());
            $abilitiesDTO = AbilitiesDTO::fromModel($ability);


            return response()->json([
                'status' => true,
                'Habilidade' => $abilitiesDTO,
                'message' => 'Habilidade atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível atualizar a habilidade',
            ], 400);
        }
    }

    public function excluirAbilities(Abilities $ability): JsonResponse
    {
        try {
            $ability->delete();

            return response()->json([
                'status' => true,
                'Habilidade Excluida' => $ability,
                'message' => 'Habilidade excluída com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível excluir a habilidade',
            ], 400);
        }
    }
}
