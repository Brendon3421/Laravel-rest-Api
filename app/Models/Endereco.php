<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    //referencia da tabela que esta sendo utilizada
    protected $table = 'endereco';  

    // Se você não quiser que o modelo use os timestamps, defina como false
    public $timestamps = true;

    // Defina quais campos podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'empresa_id',
        'situacao_id',
        'name',
        'cep',
        'rua',
        'numero',
        'complemento',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class);
    }
    public function empresas()
    {
        return $this->belongsTo(Empresas::class);
    }
    
}

