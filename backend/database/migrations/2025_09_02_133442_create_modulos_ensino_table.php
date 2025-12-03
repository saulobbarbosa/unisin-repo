<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modulos_ensino', function (Blueprint $table) {
            $table->id('id_modulo_ensino');
            $table->string('nome', 45);
            $table->unsignedBigInteger('nivel_ensino_id_nivel_ensino');

            // Foreign key
            $table->foreign('nivel_ensino_id_nivel_ensino')
                ->references('id_nivel_ensino')->on('niveis_ensino')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modulos_ensino');
    }
};
