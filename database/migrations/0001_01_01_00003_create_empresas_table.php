<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('user_id')->nullable(); // FK será adicionada em uma migration separada
            $table->foreignId('situacao_id')->default(1); // FK será adicionada em uma migration separada
            $table->foreignId('endereco_id')->nullable(); // FK será adicionada em uma migration separada
            $table->string('cnpj', 14); // CNPJ deve ser uma string para incluir zeros à esquerda
            $table->string('razao_social', 255);
            $table->string('inscricao_estadual', 255);
            $table->date('fundacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
