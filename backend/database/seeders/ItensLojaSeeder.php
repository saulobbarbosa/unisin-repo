<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItensLojaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('itens_loja')->insert([
            ['preco' => 10.00],
            ['preco' => 25.50],
            ['preco' => 100.00],
        ]);
    }
}

