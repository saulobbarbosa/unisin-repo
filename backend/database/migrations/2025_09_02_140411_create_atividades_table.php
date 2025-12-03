<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id('id_atividade');
            $table->enum('tipo', ['MULTIPLA_ESCOLHA', 'DISSERTATIVA', 'VERDADEIRO_FALSO'])->nullable();
            $table->string('pergunta', 255);
            $table->string('resposta', 255);
            $table->unsignedBigInteger('conteudo_id_conteudo');

            $table->foreign('conteudo_id_conteudo')
                ->references('id_conteudo')->on('conteudos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
