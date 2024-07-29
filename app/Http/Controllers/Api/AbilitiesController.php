<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abilities;
use App\Models\Ability;
use App\Services\AbilitiesServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbilitiesController extends Controller
{
    protected $abilitiesService;

    public function __construct(AbilitiesServices $abilitiesService)
    {
        $this->abilitiesService = $abilitiesService;
    }

    public function index(): JsonResponse
    {
        return $this->abilitiesService->listarAbilities();
    }

    public function show(Abilities $ability): JsonResponse
    {
        return $this->abilitiesService->listarAbilitiesId($ability);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->abilitiesService->criarAbilities($request);
    }

    public function update(Request $request, Abilities $ability): JsonResponse
    {
        return $this->abilitiesService->editarAbilitiesId($request, $ability);
    }

    public function destroy(Abilities $ability): JsonResponse
    {
        return $this->abilitiesService->excluirAbilities($ability);
    }
}
