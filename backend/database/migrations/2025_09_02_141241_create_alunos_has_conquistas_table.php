<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alunos_has_conquistas', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario');
            $table->unsignedBigInteger('conquista_id_conquista');

            $table->primary(['aluno_id_usuario', 'conquista_id_conquista']);

            $table->foreign('aluno_id_usuario')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('conquista_id_conquista')
                ->references('id_conquista')->on('conquistas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos_has_conquistas');
    }
};
