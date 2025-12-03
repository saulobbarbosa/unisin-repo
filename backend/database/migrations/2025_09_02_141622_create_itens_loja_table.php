<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itens_loja', function (Blueprint $table) {
            $table->id('id_item_loja');
            $table->decimal('preco', 10, 2)->default(0.00);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itens_loja');
    }
};
