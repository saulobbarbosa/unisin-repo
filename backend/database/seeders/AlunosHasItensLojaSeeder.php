<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunosHasItensLojaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos_has_itens_loja')->insert([
            ['aluno_id_usuario' => 1, 'item_loja_id_item_loja' => 1],
            ['aluno_id_usuario' => 1, 'item_loja_id_item_loja' => 2]
        ]);
    }
}
