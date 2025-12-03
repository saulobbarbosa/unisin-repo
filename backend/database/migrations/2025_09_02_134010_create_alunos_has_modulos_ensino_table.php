<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alunos_has_modulos_ensino', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario');
            $table->unsignedBigInteger('modulo_ensino_id_modulo_ensino');

            $table->primary(['aluno_id_usuario', 'modulo_ensino_id_modulo_ensino']);

            $table->foreign('aluno_id_usuario')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('modulo_ensino_id_modulo_ensino')
                ->references('id_modulo_ensino')->on('modulos_ensino')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos_has_modulos_ensino');
    }
};
