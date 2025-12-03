<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunosHasModulosEnsinoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos_has_modulos_ensino')->insert([
            ['aluno_id_usuario' => 1, 'modulo_ensino_id_modulo_ensino' => 1],
            ['aluno_id_usuario' => 1, 'modulo_ensino_id_modulo_ensino' => 2]
        ]);
    }
}
