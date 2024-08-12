<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    use HasFactory;

    //tabela  
    protected $table = 'contatos';
    // coluna de created e updatede
    public $timestamps = true;
    // colunas preenchivel
    protected $fillable = [
        "user_id",
        "empresa_id",
        "email",
        "celular",
        "telefone_fixo",
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(endereco::class, 'empresa_id');
    }
}
