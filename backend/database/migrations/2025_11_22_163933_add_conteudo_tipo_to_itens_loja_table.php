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
        Schema::table('itens_loja', function (Blueprint $table) {
            // Adiciona 'nome' logo no início, e os outros campos após o preço
            $table->string('nome', 255)->after('id_item_loja'); 
            $table->string('conteudo', 255)->nullable()->after('preco');
            $table->string('tipo', 255)->nullable()->after('conteudo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itens_loja', function (Blueprint $table) {
            $table->dropColumn(['nome', 'conteudo', 'tipo']);
        });
    }
};