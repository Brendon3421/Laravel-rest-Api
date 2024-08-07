<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolesRequest;
use App\Models\Role;
use App\Services\RolesServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected $rolesServices;

    public function __construct(RolesServices $rolesServices)
    {
        $this->rolesServices = $rolesServices;
    }

    public function index(): JsonResponse
    {
        return $this->rolesServices->listarRoleUser();
    }

    public function show(Role $roles): JsonResponse
    {
        return $this->rolesServices->listarRoleUserId($roles);
    }

    public function store(RolesRequest $request): JsonResponse
    {
        return $this->rolesServices->criarRoleUser($request);
    }

    public function update(RolesRequest $request, Role $roles)
    {
        return $this->rolesServices->editarRoleUser($roles, $request);
    }

    public function destroy(Role $roles)
    {
        return $this->rolesServices->excluirRoleUser($roles);
    }
}
