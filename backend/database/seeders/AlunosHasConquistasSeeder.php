<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunosHasConquistasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos_has_conquistas')->insert([
            ['aluno_id_usuario' => 1, 'conquista_id_conquista' => 1],
            ['aluno_id_usuario' => 1, 'conquista_id_conquista' => 2]
        ]);
    }
}
