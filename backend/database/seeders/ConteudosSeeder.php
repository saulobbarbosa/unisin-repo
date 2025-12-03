<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConteudosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('conteudos')->insert([
            ['id_nivel_ensino' => 1, 'nome_conteudo' => 'Adição e Subtração', 'professor_id_usuario' => 1],
            ['id_nivel_ensino' => 2, 'nome_conteudo' => 'Física Básica', 'professor_id_usuario' => 1],
            ['id_nivel_ensino' => 3, 'nome_conteudo' => 'Programação em PHP', 'professor_id_usuario' => 1],
        ]);
    }
}
