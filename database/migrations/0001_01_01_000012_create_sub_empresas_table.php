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
        Schema::create('sub_empresas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('cnpj');
            $table->string('razao_social', 255);
            $table->string('inscricao_estadual', 255);
            $table->date('fundacao');
                        //rodar php artisan migrate --path=/database/migrations/Fk para puxar as Fk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_empresas');
    }
};
