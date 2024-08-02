<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleUserRequest;
use App\Models\RoleUser;
use App\Services\RoleUserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public $roleUserServices;

    public function __construct(RoleUserServices $roleUserServices)
    {
        return $this->roleUserServices = $roleUserServices;
    }

    public function index(): JsonResponse
    {
        return $this->roleUserServices->listarRoleUserServices();
    }

    public function show(RoleUser $rolesUser): JsonResponse
    {
        return $this->roleUserServices->listarRoleUserServicesId($rolesUser);
    }
    public function store(RoleUserRequest $request)
    {
        return $this->roleUserServices->criarRoleUserServices($request);
    }
    public function update(RoleUser $rolesUser, RoleUserRequest $request): JsonResponse
    {
        return $this->roleUserServices->editarRoleUserServices($rolesUser, $request);
    }

    public function destroy(RoleUser $rolesUser): JsonResponse
    {
        return $this->roleUserServices->excluirRoleUserServices($rolesUser);
    }
}
