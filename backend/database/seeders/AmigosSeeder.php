<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmigosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('amigos')->insert([
            ['aluno_id_usuario1' => 1, 'aluno_id_usuario2' => 1],
        ]);
    }
}
