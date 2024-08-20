<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoEmpresa extends Model
{
    use HasFactory;

    // Tabela associada ao modelo
    protected $table = 'contato_empresa';


    // Colunas de timestamps (created_at e updated_at)
    public $timestamps = true;

    // Colunas preenchíveis
    protected $fillable = [
        'empresa_id',
        'sub_empresa_id',
        'nome',
        'email',
        'celular',
        'telefone_fixo',
        'imagem',
        'descricao',
        'created_at',
        'updated_at',
    ];

    // Relação com o modelo User
    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    // public function sub_empresa()
    // {
    //     return $this->belongsTo(subem::class, 'sub_empresa_id');
    // }

}