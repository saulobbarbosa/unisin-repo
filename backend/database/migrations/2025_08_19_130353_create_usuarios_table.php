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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // Cria a chave primária `id_usuario`
            $table->string('nome', 45);
            $table->dateTime('dt_nasc');
            $table->string('email', 45)->unique(); // unique() garante que não haverá e-mails repetidos
            $table->string('senha'); // Senhas devem ter mais de 45 caracteres após a criptografia
            $table->string('telefone', 15)->unique(); // Adiciona a coluna telefone que pode ser nula
            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
