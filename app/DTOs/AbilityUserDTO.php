<?php

namespace App\DTOs;

use App\Http\Requests\AbilityUserRequest;
use App\Models\AbilityUser;

class AbilityUserDTO {

    public $id;
    public $user_id;
    public $ability_id;
    public $created_at;
    public $updated_at;

    public function __construct($id,$user_id,$ability_id,$created_at,$updated_at)
    {
        $this->id = $id; 
        $this->user_id = $user_id; 
        $this->ability_id = $ability_id; 
        $this->created_at = $created_at; 
        $this->updated_at = $updated_at; 
    }


    public static function fromModel(AbilityUser $abilityUser): self
    {
        return new self (
            $abilityUser->id,
            $abilityUser->user->name ?? "Nao foi encontrando o nome do usuario", // Assumindo que o campo de nome do usuário é 'name'
            $abilityUser->ability->name ?? "Nao foi encontrado o nome da habilidade" ,           ///ll, // Assumindo que o campo de nome da habilidade é 'name'
            $abilityUser->created_at,
            $abilityUser->updated_at
        );
    }

    public static function MakefromModel(AbilityUser $abilityUser,  AbilityUserRequest $AbilityRoleUser): self
    {
        return new self (
            $AbilityRoleUser->id,
            $abilityUser->user->name ?? "Nao foi encontrando o nome do usuario", // Assumindo que o campo de nome do usuário é 'name'
            $abilityUser->ability->name ?? "Nao foi encontrado o nome da habilidade" ,    
            $AbilityRoleUser->created_at,
            $AbilityRoleUser->updated_at,
        );
    }

        public function toArray():array
        {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "ability_id" => $this->ability_id,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ];
        }
}