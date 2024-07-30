<?php

namespace App\DTOs;

use App\Http\Requests\RolesRequest;
use App\Models\Role;
use Illuminate\Support\Collection;

class RolesDTO
{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function makeFromModel(RolesRequest $request): self
    {
        return new self(
            $request->id,
            $request->name,
            now(),
            now(),
        );
    }

    public static function fromModel(Role $roles):self
    {
        return new self(
            $roles->id,
            $roles->name,
            $roles->created_at,
            $roles->updated_at,
        );
    }


    public static function fromCollection(Collection $roles): Collection
    {
        return $roles->map(function ($roles) {
            return self::fromModel($roles);
        });
    }


    public function toArray():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
