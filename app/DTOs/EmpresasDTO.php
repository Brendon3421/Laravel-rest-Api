<?php

namespace App\DTOs;

use App\Http\Requests\EmpresasRequest;
use App\Models\Empresas;

class EmpresasDTO
{
    public $id;
    public $name;
    public $user_id;
    public $situacao_id;
    public $contato_empresa_id;
    public $cnpj;
    public $razao_social;
    public $inscricao_estadual;
    public $fundacao;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id,
        $name,
        $user_id,
        $situacao_id, // Corrigido para situacao_id antes de contato_empresa_id
        $contato_empresa_id,
        $cnpj,
        $razao_social,
        $inscricao_estadual,
        $fundacao,
        $created_at,
        $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->user_id = $user_id;
        $this->situacao_id = $situacao_id; // Agora é atribuído corretamente
        $this->contato_empresa_id = $contato_empresa_id;
        $this->cnpj = $cnpj;
        $this->razao_social = $razao_social;
        $this->inscricao_estadual = $inscricao_estadual;
        $this->fundacao = $fundacao;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }


    public static function fromModel(Empresas $empresas): self
    {
        return new self(
            $empresas->id,
            $empresas->name,
            $empresas->user->name,
            $empresas->situacao_id,
            $empresas->contato_empresa_id,
            $empresas->cnpj,
            $empresas->razao_social,
            $empresas->inscricao_estadual,
            $empresas->fundacao,
            $empresas->created_at,
            $empresas->updated_at
        );
    }

    public static function makefromModel(EmpresasRequest $request, $user_id): self
    {
        return new self(
            $request->id,
            $request->name,
            $user_id,
            $request->situacao_id,
            $request->contato_empresa_id,
            $request->cnpj,
            $request->razao_social,
            $request->inscricao_estadual,
            $request->fundacao,
            now(),
            now()
        );
    }

    public static function fromModelCreate(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['name'],
            $data['user_id'],
            $data['situacao_id'] ?? 1,
            $data['contato_empresa_id'] ?? null,
            $data['cnpj'],
            $data['razao_social'] ?? null,
            $data['inscricao_estadual'],
            $data['fundacao'] ?? null,
            now(),
            now()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'situacao_id' => $this->situacao_id,
            // 'endereco_id' => $this->endereco_id,
            'contato_empresa_id' => $this->contato_empresa_id,
            'cnpj' => $this->cnpj,
            'razao_social' => $this->razao_social,
            'inscricao_estadual' => $this->inscricao_estadual,
            'fundacao' => $this->fundacao,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
