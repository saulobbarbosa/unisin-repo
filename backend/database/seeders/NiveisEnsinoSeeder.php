<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NiveisEnsinoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('niveis_ensino')->insert([
            ['nome' => 'Fundamental'],
            ['nome' => 'Médio'],
            ['nome' => 'Superior'],
        ]);
    }
}

