<?php

namespace App\DTOs;

use App\Models\Contatos;

class ContatosDTO
{
    public $id;
    public $user_id;
    public $empresa_id;
    public $email;
    public $celular;
    public $telefone_fixo;
    public $created_at;
    public $updated_at;

    public function __construct($id, $user_id, $empresa_id, $email, $celular, $telefone_fixo, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->empresa_id = $empresa_id;
        $this->email = $email;
        $this->celular = $celular;
        $this->telefone_fixo = $telefone_fixo;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromModel(Contatos $contatos): self
    {
        return new self(
            $contatos->id,
            $contatos->user_id,
            $contatos->empresa_id,
            $contatos->email,
            $contatos->celular,
            $contatos->telefone_fixo,
            $contatos->created_at,
            $contatos->updated_at
        );
    }

    public static function MakefromModel(array $data, $user_id, $empresa_id): self
    {
        return new self(
            null, // ID será definido pelo banco de dados após a criação
            $user_id,
            $empresa_id,
            $data['email'] ?? null,
            $data['celular'] ?? null,
            $data['telefone_fixo'] ?? null,
            now(),
            now()
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "empresa_id" => $this->empresa_id,
            "email" => $this->email,
            "celular" => $this->celular,
            "telefone_fixo" => $this->telefone_fixo,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
