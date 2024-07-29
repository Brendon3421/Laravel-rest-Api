<?php

namespace App\DTOs;

use App\Models\abilities;
use Illuminate\Support\Collection;

class AbilitiesDTO
{


    public $id;
    public $name;
    public $created_at;

    public function __construct($id, $name, $created_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
    }

    public static function fromModel(abilities $ability): self
    {
        return new self(
            $ability->id,
            $ability->name,
            $ability->created_at
        );
    }

    public static function fromCollection(Collection $abilities): Collection
    {
        return $abilities->map(function ($ability) {
            return self::fromModel($ability);
        });
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at
        ];
    }
}
