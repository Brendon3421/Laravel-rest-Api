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
        Schema::create('contatos_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nome');
            $table->string('email');
            $table->integer('celular')->unique();
            $table->integer('telefone_fixo');
            $table->string('imagem')->nullable();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};