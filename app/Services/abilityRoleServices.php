<?php

namespace App\Services;

use App\DTOs\abilityRoleDTO;
use App\Http\Requests\abilityRoleRequest;
use App\Models\AbilityRole;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class abilityRoleServices
{

    public function listarAbilityRole(): JsonResponse
    {
        try {
            $abilityRole = AbilityRole::with(['role', 'ability'])->orderBy('ID', 'DESC')->paginate(3);
            $abilityroleDTO = $abilityRole->map(function ($abilityRole) {
                return AbilityRoleDTO::fromModel($abilityRole)->toArray();
            });

            return response()->json([
                'status' => true,
                'habilidades que a Regra possui' => $abilityroleDTO,
                'message' => 'Regras com habilidades listadas com sucesso',
                'pagination' => [
                    'total' => $abilityRole->total(),
                    'count' => $abilityRole->count(),
                    'per_page' => $abilityRole->perPage(),
                    'current_page' => $abilityRole->currentPage(),
                    'total_pages' => $abilityRole->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao listar',
            ], 400);
        }
    }

    public function listarAbilityRoleId(AbilityRole $abilityRole): JsonResponse
    {
        try {
            $abilityRole->load(['role', 'ability'])->paginate(3);
            $abilityroleDTO = abilityRoleDTO::fromModel($abilityRole);
            return response()->json([
                'status' => true,
                'habilidades que a Regra possui' => $abilityroleDTO,
                'message' => 'Regras com habilidades listadas com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao listar',
            ], 400);
        }
    }
    public function criarAbilityRole(AbilityRoleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Verifica se a combinação role_id e ability_id já existe
            $exists = AbilityRole::where('role_id', $request->role_id)
                ->where('ability_id', $request->ability_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Essa combinação de role_id e ability_id já existe',
                ], 400);
            }

            // Cria o novo registro se não existir
            $abilityRole = AbilityRole::create($request->validated());
            $abilityRoleDTO = AbilityRoleDTO::fromModel($abilityRole)->toArray();

            DB::commit();

            return response()->json([
                'status' => true,
                'Habilidade adicionada à regra' => $abilityRoleDTO,
                'messages' => 'Habilidade adicionada com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao adicionar habilidade a essa regra',
            ], 400);
        }
    }
    public function editarAbilityRole(AbilityRole $abilityRole, AbilityRoleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $updatedRoles = [];
            foreach ($request->roles as $requestData) {
                if (isset($requestData['id'])) {
                    // If 'id' is present, update the existing record
                    $abilityRole = AbilityRole::findOrFail($requestData['id']);
                    $abilityRole->update($requestData);
                } else {
                    // If 'id' is not present, create a new record
                    $abilityRole = AbilityRole::updateOrCreate(
                        ['role_id' => $requestData['role_id'], 'ability_id' => $requestData['ability_id']],
                        $requestData
                    );
                }
                $updatedRoles[] = AbilityRoleDTO::fromModel($abilityRole)->toArray();
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'Regra com habilidades' => $updatedRoles,
                'message' => 'Regras atualizadas com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao atualizar regras do usuário',
            ], 400);
        }
    }
    public function excluirAbilityRole(AbilityRole $abilityRole)
    {
        try {
            DB::beginTransaction();
            $abilityRole->delete();
            $abilityRoleDTO = abilityRoleDTO::fromModel($abilityRole)->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'Habilidade da regra deletada' => $abilityRoleDTO,
                'message' => "A habilidade da regra foi deletada com sucesso",
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => "Nao foi possivel deletar a regra",
            ],400);
        }
    }
}
