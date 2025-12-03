<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtividadesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('atividades')->insert([
            [
                'tipo' => 'MULTIPLA_ESCOLHA',
                'pergunta' => 'Qual é a capital do Brasil?',
                'resposta' => 'Brasília',
                'conteudo_id_conteudo' => 1
            ],
            [
                'tipo' => 'DISSERTATIVA',
                'pergunta' => 'Explique a diferença entre massa e peso.',
                'resposta' => 'Massa é a quantidade de matéria; peso é a força da gravidade sobre a massa.',
                'conteudo_id_conteudo' => 2
            ],
            [
                'tipo' => 'VERDADEIRO_FALSO',
                'pergunta' => 'O Sol é uma estrela?',
                'resposta' => 'Verdadeiro',
                'conteudo_id_conteudo' => 3
            ],
        ]);
    }
}
