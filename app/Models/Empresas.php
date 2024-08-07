<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    //tabela  
    protected $table = 'empresas';
    // coluna de created e updatede
    public $timestamps = true;
    // colunas preenchivel
    protected $fillable = [
        "id",
        "name",
        "cnpj",
        "razao_social",
        "inscricao_estadual",
        "fundacao",
        "situacao_id",
        "endereco_id",
        "contato_id"
    ];

    public function situacao()
    {
        return $this->belongsTo(situacao::class);
    }

    public function endereco()
    {
        return $this->belongsTo(endereco::class);
    }


}
