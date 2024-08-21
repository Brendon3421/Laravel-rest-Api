<?php

namespace App\DTOs;

use App\Http\Requests\ContatoEmpresaRequest;
use App\Http\Requests\ContatosUserRequest;
use App\Models\ContatoEmpresa;
use App\Models\contatosUser;

class ContatoEmpresaDTO
{
    public $id;
    public $empresa_id;
    public $sub_empresa_id;
    public $nome;
    public $email;
    public $celular;
    public $telefone_fixo;
    public $imagem;
    public $descricao;
    public $updated_at;
    public $created_at;

    public function __construct($id, $empresa_id, $sub_empresa_id,$nome, $email, $celular, $telefone_fixo, $imagem, $descricao, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->empresa_id = $empresa_id;
        $this->sub_empresa_id = $sub_empresa_id;
        $this->nome = $nome;
        $this->email = $email;
        $this->celular = $celular;
        $this->telefone_fixo = $telefone_fixo;
        $this->imagem = $imagem;
        $this->descricao = $descricao;
        $this->updated_at = $updated_at;
        $this->created_at = $created_at;
    }

    public static function fromModel(ContatoEmpresa $contatos): self
    {
        return new self(
            $contatos->id,
            $contatos->empresa->name ?? "Empresa nao encontrada",
            $contatos->sub_empresa_id,
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

    public static function makeFromModel(ContatoEmpresaRequest $request, $empresa_id ,$sub_empresa_id): self
    {
        return new self(
            null, // ID será definido pelo banco de dados após a criação
            $empresa_id, // Corrigido para usar o $empresa_id passado como argumento
            $sub_empresa_id,
            $request->nome,
            $request->email,
            $request->celular,
            $request->telefone_fixo,
            $request->file('imagem')->store('images/contatoEmpresa'),
            $request->descricao,
            now(),
            now()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
            'sub_empresa_id' => $this->sub_empresa_id,
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
