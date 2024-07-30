<?php

namespace App\Services;

use App\DTOs\RolesDTO;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;

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
    public function criarRoleUser()
    {
    }
    public function editarRoleUser()
    {
    }
    public function excluirRoleUser()
    {
    }
}
