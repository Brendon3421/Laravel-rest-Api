<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verifica se as chaves estrangeiras já existem
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'users' AND CONSTRAINT_NAME = 'users_genero_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('genero_id')->after('name')->nullable()->constrained('genero')->onDelete('set null');
            }
            
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'users' AND CONSTRAINT_NAME = 'users_situacao_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('situacao_id')->after('genero_id')->default(1)->constrained('situacao')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'users' AND CONSTRAINT_NAME = 'users_empresa_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('empresa_id')->after('situacao_id')->constrained('empresas')->onDelete('cascade');
            }
        });

        // Adiciona as chaves estrangeiras na tabela 'contatos'
        Schema::table('contatos', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'contatos' AND CONSTRAINT_NAME = 'contatos_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('user_id')->after('name')->references('id')->on('users')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'contatos' AND CONSTRAINT_NAME = 'contatos_empresa_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('empresa_id')->after('user_id')->references('id')->on('empresas')->onDelete('cascade');
            }
        });

        // Adiciona as chaves estrangeiras na tabela 'sub_empresas'
        Schema::table('sub_empresas', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas' AND CONSTRAINT_NAME = 'sub_empresas_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('user_id')->after('name')->nullable()->constrained('users')->onDelete('set null');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas' AND CONSTRAINT_NAME = 'sub_empresas_empresa_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('empresa_id')->after('user_id')->nullable()->constrained('empresas')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas' AND CONSTRAINT_NAME = 'sub_empresas_situacao_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('situacao_id')->after('user_id')->default(1)->constrained('situacao')->onDelete('cascade');
            }
        });

        // Adiciona as chaves estrangeiras na tabela 'empresas'
        Schema::table('empresas', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'empresas' AND CONSTRAINT_NAME = 'empresas_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('user_id')->after('name')->nullable()->references('id')->on('users')->onDelete('set null');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'empresas' AND CONSTRAINT_NAME = 'empresas_situacao_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('situacao_id')->after('user_id')->references('id')->on('situacao')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'empresas' AND CONSTRAINT_NAME = 'empresas_endereco_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('endereco_id')->after('situacao_id')->nullable()->references('id')->on('endereco')->onDelete('set null');
            }
        });
        
        Schema::table('sub_empresas_users', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas_users' AND CONSTRAINT_NAME = 'sub_empresas_users_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            }
        
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas_users' AND CONSTRAINT_NAME = 'sub_empresas_users_subEmpresas_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('subEmpresas_id')->after('user_id')->nullable()->constrained('sub_empresas')->onDelete('cascade');
            }
        });

        Schema::table('endereco', function (Blueprint $table) {
            // Verifica se as chaves estrangeiras já existem antes de adicionar
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'endereco' AND CONSTRAINT_NAME = 'endereco_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('user_id')->after('name')->nullable()->constrained('users')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'endereco' AND CONSTRAINT_NAME = 'endereco_situacao_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('situacao_id')->after('situacao_id')->nullable()->default(1)->constrained('situacao')->onDelete('cascade');
            }
        });


    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove as chaves estrangeiras da tabela 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['genero_id']);
            $table->dropForeign(['contato_id']);
            $table->dropForeign(['empresa_id']);
        });

        // Remove as chaves estrangeiras da tabela 'contatos'
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['empresa_id']);
        });

        // Remove as chaves estrangeiras da tabela 'sub_empresas'
        Schema::table('sub_empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['situacao_id']);
        });

        // Remove as chaves estrangeiras da tabela 'empresas'
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['endereco_id']);
        });
        Schema::table('sub_empresas_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['subEmpresas_id']);
        });
      // Remove as chaves estrangeiras da tabela 'enderec
      Schema::table('endereco', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropForeign(['situacao_id']);
    });

    }
};
