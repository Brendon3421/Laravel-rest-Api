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

        // Criação da tabela 'genero'
        Schema::create('genero', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Criação da tabela 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('genero_id')->nullable()->constrained('genero')->onDelete('set null');
            $table->foreignId('situacao_id')->default(1)->constrained('situacao')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
        //tabela de endereco do usuario
        Schema::create('endereco', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('situacao_id')->default(1)->constrained('situacao')->onDelete('cascade');
            $table->string('name');
            $table->integer('cep');
            $table->string('rua');
            $table->integer('numero');
            $table->string('complemento');
            $table->string('ip_address', 45)->nullable();;
            $table->timestamps();
        });

        // Criação da tabela 'password_reset_tokens'
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Criação da tabela 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('endereco');
        Schema::dropIfExists('genero');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
    }
};