<?php

namespace App\Services;

use App\DTOs\AbilitiesDTO;
use App\Http\Requests\AbilitiesRequest;
use App\Models\Abilities;
use App\Models\Ability;
use Illuminate\Http\Request;
use Exception;

class AbilitiesServices
{
    public function listarAbilities()
    {
        try {
            $abilities = Abilities::orderBy('id', 'DESC')->paginate(3);
            $abilitiesDTO = AbilitiesDTO::fromCollection($abilities->getCollection())->map(function ($abilityDTO) {
                $abilityDTO->name = strtoupper($abilityDTO->name);
                return $abilityDTO;
            });

            return response()->json([
                'status' => true,
                'Habilidades' => $abilitiesDTO,
                'message' => 'Habilidades listadas com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Não foi possível listar as habilidades',
            ], 400);
        }
    }

    public function listarAbilitiesId(Abilities $ability)
    {
        try {
            $abilityDTO = AbilitiesDTO::fromModel($ability);

            return response()->json([
                'status' => true,
                'Habilidade' => $abilityDTO,
                'message' => 'Habilidade listada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível listar a habilidade',
            ], 400);
        }
    }

    public function criarAbilities(AbilitiesRequest $request)
    {
        try {

            $ability = Abilities::create($request);

            return response()->json([
                'status' => true,
                'Habilidade' => AbilitiesDTO::fromModel($ability),
                'message' => 'Habilidade criada com sucesso'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível criar a habilidade',
            ], 400);
        }
    }

    public function editarAbilitiesId(Request $request, Abilities $ability)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $ability->update($validatedData);

            return response()->json([
                'status' => true,
                'Habilidade' => AbilitiesDTO::fromModel($ability),
                'message' => 'Habilidade atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível atualizar a habilidade',
            ], 400);
        }
    }

    public function excluirAbilities(Abilities $ability)
    {
        try {
            $ability->delete();

            return response()->json([
                'status' => true,
                'message' => 'Habilidade excluída com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível excluir a habilidade',
            ], 400);
        }
    }
}