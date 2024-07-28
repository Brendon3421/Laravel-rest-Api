<?php
namespace App\DTOs;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserDTO
{
    public $id;
    public $name;
    public $email;
    public $email_verified_at;
    public $password;
    public $genero_id;
    public $situacao_id;
    public $remember_token;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id,
        $name,
        $email,
        $email_verified_at,
        $password,
        $genero_id,
        $situacao_id,
        $remember_token,
        $created_at,
        $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->email_verified_at = $email_verified_at;
        $this->password = $password;
        $this->genero_id = $genero_id;
        $this->situacao_id = $situacao_id;
        $this->remember_token = $remember_token;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromModel(User $usuario): self
    {
        return new self(
            $usuario->id,
            $usuario->name,
            $usuario->email,
            $usuario->email_verified_at,
            "oculto", // Password is hidden
            $usuario->genero->name ?? null,
            $usuario->situacao->name ?? null,
            $usuario->remember_token,
            $usuario->created_at,
            $usuario->updated_at
        );
    }

    public static function fromModelRequest(User $usuario, UserRequest $request): self
    {
        return new self(
            $usuario->id,
            $request->name,
            $request->email,
            $request->email_verified_at ?? $usuario->email_verified_at,
            $request->password ?? $usuario->password,
            $request->genero_id ?? $usuario->genero_id,
            $request->situacao_id ?? $usuario->situacao_id,
            $request->remember_token ?? $usuario->remember_token,
            $usuario->created_at,
            now()
        );
    }

    public static function fromModelCreate(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['name'],
            $data['email'],
            $data['email_verified_at'] ?? null,
            $data['password'],
            $data['genero_id'],
            $data['situacao_id'] ?? 1,
            $data['remember_token'] ?? null,
            now(),
            now()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'genero_id' => $this->genero_id,
            'situacao_id' => $this->situacao_id,
            'remember_token' => $this->remember_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
