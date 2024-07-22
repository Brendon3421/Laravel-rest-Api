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
        'name',
        'cep',
        'rua',
        'numero',
        'complemento',
        
    ];
}
