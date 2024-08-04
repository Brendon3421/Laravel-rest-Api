<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\abilityRoleRequest;
use App\Models\AbilityRole;
use App\Services\abilityRoleServices;
use Illuminate\Http\JsonResponse;

use function Psy\debug;

class abilityRoleController extends Controller
{
    public $abilityRoleServices;

    public function  __construct(abilityRoleServices $abilityRoleServices)
    {
        return $this->abilityRoleServices = $abilityRoleServices;
    }

    public function index(): JsonResponse
    {
        return $this->abilityRoleServices->listarAbilityRole();
    }

    public function show(AbilityRole $abilityRole): JsonResponse
    {
        return $this->abilityRoleServices->listarAbilityRoleId($abilityRole);
    }

    public function store(abilityRoleRequest $request): JsonResponse
    {
        return $this->abilityRoleServices->criarAbilityRole($request);
    }
    public function update(AbilityRole $abilityRole, AbilityRoleRequest $request): JsonResponse
    {
        // return dd($abilityRole, $request);
        return $this->abilityRoleServices->editarAbilityRole($abilityRole, $request);
    }
    public function destroy(AbilityRole $abilityRole)
    {
        return $this->abilityRoleServices->excluirAbilityRole($abilityRole);
    }
}
