<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunosHasConteudosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos_has_conteudos')->insert([
            ['aluno_id_usuario' => 1, 'conteudo_id_conteudo' => 1, 'status_conteudo' => 1],
            ['aluno_id_usuario' => 1, 'conteudo_id_conteudo' => 2, 'status_conteudo' => 0]
        ]);
    }
}

