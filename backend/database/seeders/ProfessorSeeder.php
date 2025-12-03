<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('professores')->insert([
            [
                'id_usuario' => 1, 
                'escola_id_escola' => 7,
            ]
        ]);
    }
}
