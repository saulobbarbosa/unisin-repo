<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->primary();
            $table->unsignedBigInteger('escola_id_escola');

            // Foreign keys
            $table->foreign('id_usuario')
                ->references('id_usuario')->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('escola_id_escola')
                ->references('id_escola')->on('escolas')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professores');
    }
};
