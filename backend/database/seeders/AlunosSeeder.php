<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos')->insert([
            [
                'id_usuario' => 1,
                'moedas' => 50,
            ]
        ]);
    }
}

