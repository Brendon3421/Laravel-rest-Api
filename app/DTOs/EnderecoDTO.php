<?php

namespace App\DTOs;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;

class EnderecoDTO
{
    public $id;
    public $user_name;
    public $situacao_id;
    public $name;
    public $cep;
    public $rua;
    public $numero;
    public $complemento;
    public $ip_address;
    public $created_at;
    public $updated_at;

    public function __construct($id, $user_name, $situacao_id, $name, $cep, $rua, $numero, $complemento, $ip_address, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user_name = $user_name;
        $this->situacao_id = $situacao_id;
        $this->name = $name;
        $this->cep = $cep;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->ip_address = $ip_address;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function makeFromRequest(EnderecoRequest $request, $user_id): self
    {
        return new self(
            $request->id,
            $user_id,
            $request->situacao_id,
            $request->name,
            $request->cep,
            $request->rua,
            $request->numero,
            $request->complemento,
            $request->ip(),
            now(),
            $request->updated_at,

        );
    }

    public static function fromModel(Endereco $endereco): self
    {
        return new self(
            $endereco->id,
            $endereco->user->name ?? 'Usuário não encontrado',
            $endereco->situacao->name ?? 'Situação não encontrada',
            $endereco->name,
            $endereco->cep,
            $endereco->rua,
            $endereco->numero,
            $endereco->complemento,
            $endereco->ip_address,
            $endereco->created_at,
            $endereco->updated_at
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'Nome do Usuario' => $this->user_name,
            'Situacao' => $this->situacao_id,
            'name' => $this->name,
            'cep' => $this->cep,
            'rua' => $this->rua,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'ip_address' => $this->ip_address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
