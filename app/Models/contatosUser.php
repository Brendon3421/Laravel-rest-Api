<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contatosUser extends Model
{
    use HasFactory;

    // Tabela associada ao modelo
    protected $table = 'contatos_user';


    // Colunas de timestamps (created_at e updated_at)
    public $timestamps = true;

    // Colunas preenchíveis
    protected $fillable = [
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
