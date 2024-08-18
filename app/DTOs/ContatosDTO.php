<?php

namespace App\DTOs;

use App\Http\Requests\ContatosUserRequest;
use App\Models\contatosUser;

class ContatosDTO
{
    public $id;
    public $user_id;
    public $nome;
    public $email;
    public $celular;
    public $telefone_fixo;
    public $imagem;
    public $descricao;
    public $updated_at;
    public $created_at;

    public function __construct($id, $user_id, $nome, $email, $celular, $telefone_fixo, $imagem, $descricao, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->nome = $nome;
        $this->email = $email;
        $this->celular = $celular;
        $this->telefone_fixo = $telefone_fixo;
        $this->imagem = $imagem;
        $this->descricao = $descricao;
        $this->updated_at = $updated_at;
        $this->created_at = $created_at;
    }

    public static function fromModel(contatosUser $contatos): self
    {
        return new self(
            $contatos->id,
            $contatos->user_id,
            $contatos->nome,
            $contatos->email,
            $contatos->celular,
            $contatos->telefone_fixo,
            $contatos->imagem,
            $contatos->descricao,
            $contatos->updated_at,
            $contatos->created_at,
        );
    }

    public static function makeFromModel(ContatosUserRequest $request, $user_id): self
    {
        return new self(
            null, // ID será definido pelo banco de dados após a criação
            $user_id, // Corrigido para usar o $user_id passado como argumento
            $request->nome,
            $request->email,
            $request->celular,
            $request->telefone_fixo,
            $request->imagem,
            $request->descricao,
            now(),
            now()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nome' => $this->nome,
            'email' => $this->email,
            'celular' => $this->celular,
            'telefone_fixo' => $this->telefone_fixo,
            'imagem' => $this->imagem,
            'descricao' => $this->descricao,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
