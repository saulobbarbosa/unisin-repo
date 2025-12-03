<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escolas', function (Blueprint $table) {
            $table->id('id_escola');
            $table->string('nome', 45);
            $table->string('cep', 45)->nullable();
            $table->string('rua', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->string('estado', 45)->nullable();
            $table->unsignedBigInteger('id_usuario');

            // Relacionamento
            $table->foreign('id_usuario')
                ->references('id_usuario')->on('usuarios')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escolas');
    }
};
