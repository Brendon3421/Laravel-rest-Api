<?php

namespace App\DTOs;

use App\Models\RoleUser;

class RoleUserDTO
{
    public $id;
    public $role_name;
    public $user_name;
    public $created_at;
    public $updated_at;

    public function __construct($id, $role_name, $user_name, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->role_name = $role_name;
        $this->user_name = $user_name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromModel(RoleUser $roleUser): self
    {
        return new self(
            $roleUser->id,
            $roleUser->role->name ?? 'Não encontrado nome da regra',
            $roleUser->user->name ?? 'Não encontrado nome do usuário',
            $roleUser->created_at,
            $roleUser->updated_at
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "role_name" => $this->role_name,
            "user_name" => $this->user_name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
