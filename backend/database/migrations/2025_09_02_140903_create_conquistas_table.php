<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conquistas', function (Blueprint $table) {
            $table->id('id_conquista');
            $table->string('nome_conquista', 45);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conquistas');
    }
};
