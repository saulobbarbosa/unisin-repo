<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alunos_has_conteudos', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario');
            $table->unsignedBigInteger('conteudo_id_conteudo');
            $table->tinyInteger('status_conteudo')->default(0); // 0: Não concluído, 1: Concluído

            $table->primary(['aluno_id_usuario', 'conteudo_id_conteudo']);

            $table->foreign('aluno_id_usuario')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('conteudo_id_conteudo')
                ->references('id_conteudo')->on('conteudos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos_has_conteudos');
    }
};
