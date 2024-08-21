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
                $table->foreignId('empresa_id')->nullable()->after('situacao_id')->constrained('empresas')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'contatos_user' table
        Schema::table('contatos_user', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'contatos_user' AND CONSTRAINT_NAME = 'contatos_user_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'sub_empresas' table
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
                $table->foreignId('situacao_id')->after('empresa_id')->default(1)->constrained('situacao')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'empresas' table
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

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'empresas' AND CONSTRAINT_NAME = 'empresas_contato_empresa_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreign('contato_empresa_id')->after('endereco_id')->references('id')->on('contato_empresa')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'sub_empresas_users' table
        Schema::table('sub_empresas_users', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas_users' AND CONSTRAINT_NAME = 'sub_empresas_users_user_idforeign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'sub_empresas_users' AND CONSTRAINT_NAME = 'sub_empresas_users_sub_empresas_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('sub_empresas_id')->after('user_id')->nullable()->constrained('sub_empresas')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'endereco' table
        Schema::table('endereco', function (Blueprint $table) {
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
                $table->foreignId('situacao_id')->after('user_id')->nullable()->default(1)->constrained('situacao')->onDelete('cascade');
            }
        });

        // Add foreign keys to the 'contato_empresa' table
        Schema::table('contato_empresa', function (Blueprint $table) {
            $foreignKeyEmpresaExists = DB::select(
                "SELECT * FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'contato_empresa' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'contato_empresa_empresa_id_foreign'"
            );
            if (empty($foreignKeyEmpresaExists)) {
                $table->foreignId('empresa_id')->after('id')->constrained('empresas')->onDelete('cascade');
            }

            $foreignKeySubEmpresaExists = DB::select(
                "SELECT * FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'contato_empresa' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'contato_empresa_sub_empresa_id_foreign'"
            );
            if (empty($foreignKeySubEmpresaExists)) {
                $table->foreignId('sub_empresa_id')->after('empresa_id')->constrained('sub_empresas')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['genero_id']);
            $table->dropForeign(['empresa_id']);
        });

        Schema::table('contatos_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('sub_empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['situacao_id']);
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['endereco_id']);
            $table->dropForeign(['contato_empresa_id']);
        });

        Schema::table('sub_empresas_users', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['sub_empresas_id']);
            });

        Schema::table('endereco', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['situacao_id']);
        });

        Schema::table('contato_empresa', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['sub_empresa_id']);
        });
    }
};
