<?php

namespace App\Services;

use App\DTOs\RolesDTO;
use App\Http\Requests\RolesRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RolesServices
{

    public function __construct()
    {
    }

    public function listarRoleUser(): JsonResponse
    {
        try {
            $roles = Role::orderby('ID', 'DESC')->paginate(3);
            $rolesDTO = RolesDTO::fromCollection(collect($roles->items()));

            return response()->json([
                'staus' => true,
                'regras' => $rolesDTO,
                'message' => 'regras de usuario listada com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'staus' => true,
                'error' => $e->getMessage(),
                'message' => 'Erro ao listar regras',
            ], 400);
        }
    }
    public function listarRoleUserId(Role $roles): JsonResponse
    {
        try {
            $rolesDTO = RolesDTO::fromModel($roles);
            return response()->json([
                'status' => true,
                'Regras de Usuarios' => $rolesDTO->toArray(),
                'message' => 'Regras listadas com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Falha ao listar regras'
            ]);
        }
    }
    public function criarRoleUser(RolesRequest $request)
    {
        try {
            DB::beginTransaction();
            $roles = Role::create($request->validated());
            DB::commit();
            $rolesDTO = RolesDTO::makeFromModel($request);

            return response()->json([
                'status' => true,
                'Regra criada' => $rolesDTO,
                'message' => 'Regra criado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Regra criada' => $e->getMessage(),
                'message' => 'falha ao criar regra'
            ], 400);
        }
    }
    public function editarRoleUser(Role $roles, RolesRequest $request)
    {
        try {
            DB::beginTransaction();
            $roles->update($request->validated());
            DB::commit();
            $rolesDTO = RolesDTO::fromModel($roles);
            return response()->json([
                'status' => true,
                'Regra editada' => $rolesDTO,
                'message' => 'Regra Edita com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Falha ao editar regra',
            ], 400);
        }
    }
    public function excluirRoleUser(Role $roles)
    {
        try {
            DB::beginTransaction();
            $roles->delete();
            return response()->json([
                'status' => true,
                'Regra editada' => $roles,
                'message' => 'Regra deletada com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Falha ao excluir regra',
            ], 400);
        }
        }
    }
