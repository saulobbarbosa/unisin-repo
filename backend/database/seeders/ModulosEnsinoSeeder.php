<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosEnsinoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modulos_ensino')->insert([
            ['nome' => 'Matemática Básica', 'nivel_ensino_id_nivel_ensino' => 1],
            ['nome' => 'Português', 'nivel_ensino_id_nivel_ensino' => 1],
            ['nome' => 'Física', 'nivel_ensino_id_nivel_ensino' => 2],
            ['nome' => 'Química', 'nivel_ensino_id_nivel_ensino' => 2],
            ['nome' => 'Programação', 'nivel_ensino_id_nivel_ensino' => 3],
        ]);
    }
}
