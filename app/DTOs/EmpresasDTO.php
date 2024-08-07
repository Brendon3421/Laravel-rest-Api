<?php

namespace App\DTOs;

use App\Models\Empresas;

class EmpresasDTO
{
    public $id;
    public $name;
    public $cnpj;
    public $razao_social;
    public $inscricao_estadual;
    public $fundacao;
    public $situacao_id;
    public $endereco_id;
    public $contato_id;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id,
        $name,
        $cnpj,
        $razao_social,
        $inscricao_estadual,
        $fundacao,
        $situacao_id,
        $endereco_id,
        $contato_id,
        $created_at,
        $updated_at,
    ) {

        return new self(
            $this->id = $id,
            $this->name = $name,
            $this->cnpj = $cnpj,
            $this->razao_social = $razao_social,
            $this->inscricao_estadual = $inscricao_estadual,
            $this->fundacao = $fundacao,
            $this->situacao_id = $situacao_id,
            $this->endereco_id = $endereco_id,
            $this->contato_id = $contato_id,
            $this->created_at = $created_at,
            $this->updated_at = $updated_at,
        );
    }

    public static function makefromModel(Empresas $empresas)
    {
        return new self(
            $empresas->id,
            $empresas->name,
            $empresas->cnpj,
            $empresas->razao_social,
            $empresas->inscricao_estadual,
            $empresas->fundacao,
            $empresas->situacao->name,
            $empresas->endereco->name,
            $empresas->contato_id,
            now(),
            $empresas->updated_at,
        );
    }
    public static function UpdatedfromModel(Empresas $empresas)
    {
        return new self(
            $empresas->id,
            $empresas->name,
            $empresas->cnpj,
            $empresas->razao_social,
            $empresas->inscricao_estadual,
            $empresas->fundacao,
            $empresas->situacao->name,
            $empresas->endereco->name,
            $empresas->contato_id,
            $empresas->created_at,
            now(),
        );
    }

    public static function fromModel(Empresas $empresas)
    {
        return new self(
            $empresas->id,
            $empresas->name,
            $empresas->cnpj,
            $empresas->razao_social,
            $empresas->inscricao_estadual,
            $empresas->fundacao,
            $empresas->situacao->name,
            $empresas->endereco->name,
            $empresas->contato_id,
            $empresas->created_at,
            $empresas->updated_at,
        );
    }

    public function toArray()
    {
        return [
            'id'=>$this->id, 
            'name'=>$this->name, 
            'cnpj'=>$this->cnpj, 
            'razao_social'=>$this->razao_social, 
            'inscricao_estadual'=>$this->inscricao_estadual, 
            'fundacao'=>$this->fundacao,
            'situacao_id'=>$this->situacao_id, 
            'endereco_id'=>$this->endereco_id, 
            'contato_id'=>$this->contato_id, 
        ];
    }


}
