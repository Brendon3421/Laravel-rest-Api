<?php

namespace App\Services;

use App\DTOs\AbilityUserDTO;
use App\Http\Requests\AbilityUserRequest;
use App\Models\Abilities;
use App\Models\AbilityUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AbilityUserServices
{

    public function listarAbilityUser(): JsonResponse
    {
        try {
            $ability = AbilityUser::with(['user', 'ability'])->orderBy('ID', 'DESC')->paginate(3);
            $abilityUser = $ability->map(function ($abilities) {
                return AbilityUserDTO::fromModel($abilities)->toArray();
            });
            return response()->json([
                'status' => true,
                'Habilidades do usuario' => $abilityUser,
                'message' => 'Habilidades listados com sucesso',
                'pagination' => [
                    'total' => $ability->total(),
                    'count' => $ability->count(),
                    'per_page' => $ability->perPage(),
                    'current_page' => $ability->currentPage(),
                    'total_pages' => $ability->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Falha ao listar Habilidades dos Usuarios',
                'pagination' => [
                    'total' => 0,
                    'count' => 0,
                    'per_page' => 0,
                    'current_page' => 0,
                    'total_pages' => 0
                ]
            ], 400);
        }
    }
    public function listarAbilityUserId(AbilityUser $abilityUser): JsonResponse
    {
        try {
            $abilityUser->load(['user', 'ability']);
            $abilityUserDTO = AbilityUserDTO::fromModel($abilityUser)->toArray();
            return  response()->json([
                'status' => true,
                'Habilidade do usuario' => $abilityUserDTO,
                'message' => 'habilidades listadas com sucesso'
            ], 200);
        } catch (Exception $e) {
            return  response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao listar habilidades'
            ], 400);
        }
    }
    public function criarAbilityUser(AbilityUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $ability = AbilityUser::create($request->validated());
            $abilityUserDTO = AbilityUserDTO::fromModel($ability)->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'habilidades' => $abilityUserDTO,
                'message' => 'Regra Adicionado com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Excepetion' => $e->getMessage(),
                'error' => 'Falha ao adicionar regra ao usuario',
            ], 400);
        }
    }
    public function editarAbilityUser(AbilityUser $abilityUser, AbilityUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $updatedAbilities = [];
            foreach ($request->abilities as $abilityData) {
                $abilityUser = AbilityUser::updateOrCreate(
                    ['user_id' => $abilityData['user_id'], 'ability_id' => $abilityData['ability_id']],
                    $abilityData
                );

                $updatedAbilities[] = AbilityUserDTO::fromModel($abilityUser)->toArray();
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'habilidades' => $updatedAbilities,
                'message' => 'Regras atualizadas com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'Excepetion' => $e->getMessage(),
                'error' => 'Falha ao atualizar regras do usuário',
            ], 400);
        }
    }
    public function excluirAbilityUser(AbilityUser $abilityUser)
    {
        try {
            DB::beginTransaction();
            $abilityUser->delete();
            $abilityUserDTO = AbilityUserDTO::fromModel($abilityUser)->toArray();

            return response()->json([
                'status' => true,
                'habilidades' => $abilityUserDTO,
                'message' => 'Regra Excluida com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Excepetion' => $e->getMessage(),
                'error' => 'Falha ao excluir',
            ], 400);
        }
    }
}
