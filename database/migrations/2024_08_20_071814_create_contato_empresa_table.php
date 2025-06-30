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
        Schema::create('contato_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->integer('celular')->unique();
            $table->integer('telefone_fixo');
            $table->string('imagem')->nullable();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**w
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contato_empresa');
    }
};
