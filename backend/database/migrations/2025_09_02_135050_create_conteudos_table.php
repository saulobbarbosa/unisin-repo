<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conteudos', function (Blueprint $table) {
            $table->id('id_conteudo');
            $table->unsignedBigInteger('id_nivel_ensino');
            $table->string('nome_conteudo', 45);
            $table->unsignedBigInteger('professor_id_usuario');

            $table->foreign('id_nivel_ensino')
                ->references('id_nivel_ensino')->on('niveis_ensino')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('professor_id_usuario')
                ->references('id_usuario')->on('professores')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conteudos');
    }
};
