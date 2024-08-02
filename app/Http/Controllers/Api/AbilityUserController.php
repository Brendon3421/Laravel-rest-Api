<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbilityUserRequest;
use App\Models\AbilityUser;
use App\Services\AbilityUserServices;
use Illuminate\Http\JsonResponse;

class AbilityUserController extends Controller
{


    protected $abilityUserServices;

    public function __construct(AbilityUserServices $abilityUserServices)
    {
        $this->abilityUserServices = $abilityUserServices;
    }

    public function index(): JsonResponse
    {
        return $this->abilityUserServices->listarAbilityUser();
    }

    public function show(AbilityUser $abilityUser): JsonResponse
    {
        return $this->abilityUserServices->listarAbilityUserId($abilityUser);
    }

    public function store(AbilityUserRequest $request): JsonResponse
    {
        return $this->abilityUserServices->criarAbilityUser($request);
    }
    public function update(AbilityUser $abilityUser,   AbilityUserRequest $request): JsonResponse
    {
        return $this->abilityUserServices->editarAbilityUser($abilityUser, $request);
    }
    public function destroy(AbilityUser $abilityUser)
    {
        return $this->abilityUserServices->excluirAbilityUser($abilityUser);

    }
}
