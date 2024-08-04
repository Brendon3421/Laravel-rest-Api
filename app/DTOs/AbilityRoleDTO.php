<?php

namespace App\DTOs;

use App\Models\AbilityRole;

class AbilityRoleDTO
{
    public $id;
    public $role_name;
    public $ability_name;
    public $created_at;
    public $updated_at;

    public function __construct($id, $role_name, $ability_name, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->role_name = $role_name;
        $this->ability_name = $ability_name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromModel(AbilityRole $abilityRole): self
    {
        return new self(
            $abilityRole->id,
            $abilityRole->role->name ?? 'Não encontrado nome da regra',
            $abilityRole->ability->name ?? 'Não encontrado nome da habilidade',
            $abilityRole->created_at,
            $abilityRole->updated_at
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "role_name" => $this->role_name,
            "ability_name" => $this->ability_name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
