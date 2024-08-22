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
        "user_id",
        "situacao_id",
        "contato_empresa_id",
        "cnpj",
        "razao_social",
        "inscricao_estadual",
        "fundacao",
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class, 'situacao_id');
    }

    public function endereco()
    {
        return $this->belongsTo(endereco::class);
    }
}
