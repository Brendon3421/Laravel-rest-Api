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
        //tabela de endereco do usuario
        Schema::create('endereco', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('situacao_id')->nullable()->default(1)->constrained('situacao')->onDelete('cascade');
            $table->string('name');
            $table->integer('cep');
            $table->string('rua');
            $table->integer('numero');
            $table->string('complemento');
            $table->string('ip_address', 45)->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endereco');
    }
};
