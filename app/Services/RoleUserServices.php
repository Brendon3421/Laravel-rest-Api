<?php

namespace App\Services;

use App\DTOs\RolesDTO;
use App\DTOs\RoleUserDTO;
use App\Http\Requests\RoleUserRequest;
use App\Models\RoleUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RoleUserServices
{
    public function listarRoleUserServices(): JsonResponse
    {
        try {
            $role = RoleUser::with(['user', 'role'])->orderBy('ID', 'DESC')->paginate(3);
            $rolesUser = $role->map(function ($role) {
                return RoleUserDTO::fromModel($role)->toArray();
            });

            return response()->json([
                'status' => true,
                'Usuario com Regra' => $rolesUser,
                'message' => 'Usuario com Regra listado com sucesso',
                'pagination' => [
                    'total' => $role->total(),
                    'count' => $role->count(),
                    'per_page' => $role->perPage(),
                    'current_page' => $role->currentPage(),
                    'total_pages' => $role->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'message' => 'Erro ao listar usuario com regra',
            ], 400);
        }
    }
    public function listarRoleUserServicesId(RoleUser $rolesUser): JsonResponse
    {
        try {

            $rolesUser->load(['user', 'role']);
            $rolesUserDTO = RoleUserDTO::fromModel($rolesUser)->toArray();

            return response()->json([
                'status' => true,
                'Usuario com Regra' => $rolesUserDTO,
                'message' => 'Usuario com Regra listado com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'message' => 'Erro ao listar usuario com regra',
            ], 400);
        }
    }
    public function criarRoleUserServices(RoleUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $roles = RoleUser::create($request->validated());
            $rolesUserDTO = RoleUserDTO::fromModel($roles);
            DB::commit();
            return response()->json([
                'status' => true,
                'Regra de usuario' => $rolesUserDTO,
                'message' => 'Regra de usuario adicionando com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Falha ao adicionar regra ao usuario',
            ], 400);
        }
    }
    public function editarRoleUserServices(RoleUser $rolesUser, RoleUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $rolesUser->fill($request->validated());
            $rolesUser->save;
            $rolesUserDTO = RoleUserDTO::fromModel($rolesUser);
            DB::commit();
            return response()->json([
                'status' => true,
                'Usuario Com Regra Editada' => $rolesUserDTO,
                'message' => "Regra de usuario Editado com sucesso",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'message' => "Falha ao Editar Regra",
            ], 400);
        }
    }
    public function excluirRoleUserServices(RoleUser $rolesUser)
    {
        try {
            DB::beginTransaction();
            $rolesUser->delete();
            $rolesUserDTO = RoleUserDTO::fromModel($rolesUser);
            DB::commit();
            return response()->json([
                'status' => true,
                'Usuario Com Regra delatada' => $rolesUserDTO,
                'message' => "Regra de usuario deletada com sucesso",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'message' => "Falha ao excluir Regra",
            ], 400);
        }
    }
}
