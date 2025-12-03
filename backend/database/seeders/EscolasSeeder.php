<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscolasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('escolas')->insert([
            [
                'nome' => 'Escola Municipal Alpha',
                'cep' => '12345-678',
                'rua' => 'Rua das Flores',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'id_usuario' => 1,
            ]
        ]);
    }
}
