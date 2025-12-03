<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConquistasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('conquistas')->insert([
            ['nome_conquista' => 'Primeiro Login'],
            ['nome_conquista' => 'Primeira Atividade Concluída'],
            ['nome_conquista' => 'Mestre do Conteúdo'],
        ]);
    }
}

