<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alunos_has_itens_loja', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario');
            $table->unsignedBigInteger('item_loja_id_item_loja');

            $table->primary(['aluno_id_usuario', 'item_loja_id_item_loja']);

            $table->foreign('aluno_id_usuario')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('item_loja_id_item_loja')
                ->references('id_item_loja')->on('itens_loja')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos_has_itens_loja');
    }
};
