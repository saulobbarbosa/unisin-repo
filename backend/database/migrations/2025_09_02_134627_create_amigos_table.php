<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amigos', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario1');
            $table->unsignedBigInteger('aluno_id_usuario2');

            $table->primary(['aluno_id_usuario1', 'aluno_id_usuario2']);

            $table->foreign('aluno_id_usuario1')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('aluno_id_usuario2')
                ->references('id_usuario')->on('alunos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amigos');
    }
};
