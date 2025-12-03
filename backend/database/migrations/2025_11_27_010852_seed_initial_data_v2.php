<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // GARANTIR QUE A TABELA PERGUNTAS TENHA TIMESTAMPS
        // (Caso não tenha sido criada com eles nas migrations anteriores)
        if (!Schema::hasColumn('perguntas', 'created_at')) {
            Schema::table('perguntas', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Inicia uma transação manual para garantir atomicidade
        DB::transaction(function () {
            
            // 1. USUÁRIO, ESCOLA E PROFESSOR PADRÃO
            // Insere apenas se não existir (para evitar duplicação)
            DB::table('usuarios')->insertOrIgnore([
                'id_usuario' => 1,
                'nome' => 'Professor Padrão',
                'dt_nasc' => '1990-01-01 00:00:00',
                'email' => 'prof@escola.com',
                'senha' => bcrypt('senha123'), 
                'telefone' => '11999999999',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('escolas')->insertOrIgnore([
                'id_escola' => 1,
                'nome' => 'Escola Padrão',
                'id_usuario' => 1, // Dono da escola
            ]);

            DB::table('professores')->insertOrIgnore([
                'id_usuario' => 1,
                'escola_id_escola' => 1,
            ]);


            // 2. ITENS DA LOJA
            $itens = [
                // Bordas
                ['nome' => 'Borda Vermelha', 'preco' => 500.00, 'conteudo' => '#FF0000', 'tipo' => 'borda'],
                ['nome' => 'Borda Verde', 'preco' => 500.00, 'conteudo' => '#0DFF00', 'tipo' => 'borda'],
                ['nome' => 'Borda Azul', 'preco' => 500.00, 'conteudo' => '#3A7BFD', 'tipo' => 'borda'],
                ['nome' => 'Borda Marrom', 'preco' => 500.00, 'conteudo' => '#8D6E63', 'tipo' => 'borda'],
                ['nome' => 'Borda Preta', 'preco' => 500.00, 'conteudo' => '#000000', 'tipo' => 'borda'],
                ['nome' => 'Borda Amarela', 'preco' => 500.00, 'conteudo' => '#FFB72D', 'tipo' => 'borda'],
                // Fundos
                ['nome' => 'Fundo Vermelho', 'preco' => 1000.00, 'conteudo' => '#FF0000', 'tipo' => 'fundo'],
                ['nome' => 'Fundo Verde', 'preco' => 1000.00, 'conteudo' => '#0DFF00', 'tipo' => 'fundo'],
                ['nome' => 'Fundo Azul', 'preco' => 1000.00, 'conteudo' => '#3A7BFD', 'tipo' => 'fundo'],
                ['nome' => 'Fundo Marrom', 'preco' => 1000.00, 'conteudo' => '#8D6E63', 'tipo' => 'fundo'],
                ['nome' => 'Fundo Preto', 'preco' => 1000.00, 'conteudo' => '#000000', 'tipo' => 'fundo'],
                ['nome' => 'Fundo Amarelo', 'preco' => 1000.00, 'conteudo' => '#FFB72D', 'tipo' => 'fundo'],
                // Avatares
                ['nome' => 'Avatar Ruivo', 'preco' => 1500.00, 'conteudo' => '/imgs/perfil/boy_red.webp', 'tipo' => 'avatar'],
                ['nome' => 'Avatar Loiro', 'preco' => 1500.00, 'conteudo' => '/imgs/perfil/boy_yellow.webp', 'tipo' => 'avatar'],
                ['nome' => 'Avatar Morena', 'preco' => 1500.00, 'conteudo' => '/imgs/perfil/girl_black.webp', 'tipo' => 'avatar'],
                ['nome' => 'Avatar Ruiva', 'preco' => 1500.00, 'conteudo' => '/imgs/perfil/girl_red.webp', 'tipo' => 'avatar'],
                ['nome' => 'Avatar Loira', 'preco' => 1500.00, 'conteudo' => '/imgs/perfil/girl_yellow.webp', 'tipo' => 'avatar'],
            ];

            foreach ($itens as $item) {
                if (!DB::table('itens_loja')->where('nome', $item['nome'])->exists()) {
                    DB::table('itens_loja')->insert($item);
                }
            }


            // 3. PERGUNTAS (NÍVEL 1)
            $inserirPergunta = function ($moduloId, $enunciado, $opcoes) {
                // Verifica se a pergunta já existe
                $existe = DB::table('perguntas')
                            ->where('enunciado', $enunciado)
                            ->where('professor_id_usuario', 1)
                            ->first();
                
                if ($existe) return;

                // Insere Pergunta
                $perguntaId = DB::table('perguntas')->insertGetId([
                    'tipo' => 'MULTIPLA_ESCOLHA',
                    'enunciado' => $enunciado,
                    'professor_id_usuario' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Vincula ao Módulo e Nível (Nível 1 fixo)
                DB::table('modulo_nivel_perguntas')->insert([
                    'modulo_ensino_id' => $moduloId,
                    'nivel_id' => 1, 
                    'pergunta_id' => $perguntaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insere Opções
                foreach ($opcoes as $texto => $correta) {
                    DB::table('opcoes')->insert([
                        'pergunta_id' => $perguntaId,
                        'texto_opcao' => $texto,
                        'eh_correta' => $correta,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            };

            // ================= MATEMÁTICA (ID 1) =================
            $inserirPergunta(1, 'Quanto é 2 + 2?', ['3'=>0, '4'=>1, '5'=>0, '22'=>0]);
            $inserirPergunta(1, 'Qual número vem depois do 9?', ['8'=>0, '10'=>1, '11'=>0, '90'=>0]);
            $inserirPergunta(1, 'Se você tem 5 maçãs e come 2, quantas sobram?', ['3'=>1, '2'=>0, '7'=>0, '5'=>0]);
            $inserirPergunta(1, 'Qual forma geométrica tem 3 lados?', ['Quadrado'=>0, 'Círculo'=>0, 'Triângulo'=>1, 'Retângulo'=>0]);
            $inserirPergunta(1, 'Quanto é 10 dividido por 2?', ['2'=>0, '10'=>0, '5'=>1, '8'=>0]);


            // ================= PORTUGUÊS (ID 2) =================
            $inserirPergunta(2, 'Qual destas palavras é um verbo?', ['Casa'=>0, 'Azul'=>0, 'Correr'=>1, 'Mesa'=>0]);
            $inserirPergunta(2, 'Qual o plural de "Mão"?', ['Mães'=>0, 'Mãos'=>1, 'Mões'=>0, 'Mãozes'=>0]);
            $inserirPergunta(2, 'Quantas sílabas tem a palavra "Banana"?', ['2'=>0, '3'=>1, '4'=>0, '1'=>0]);
            $inserirPergunta(2, 'O antônimo de "Alto" é:', ['Grande'=>0, 'Baixo'=>1, 'Largo'=>0, 'Forte'=>0]);
            $inserirPergunta(2, 'Qual a primeira letra do alfabeto?', ['Z'=>0, 'B'=>0, 'A'=>1, 'H'=>0]);


            // ================= HISTÓRIA (ID 3) =================
            $inserirPergunta(3, 'Em que ano os portugueses chegaram ao Brasil?', ['1500'=>1, '1800'=>0, '1900'=>0, '2000'=>0]);
            $inserirPergunta(3, 'Quem foi o primeiro imperador do Brasil?', ['Dom Pedro II'=>0, 'Dom Pedro I'=>1, 'Tiradentes'=>0, 'Getúlio Vargas'=>0]);
            $inserirPergunta(3, 'As pirâmides famosas ficam em qual país?', ['Brasil'=>0, 'Egito'=>1, 'China'=>0, 'França'=>0]);
            $inserirPergunta(3, 'Qual era o nome original do Brasil?', ['Ilha de Vera Cruz'=>1, 'Terra do Ouro'=>0, 'Novo Mundo'=>0, 'Portugal Pequeno'=>0]);
            $inserirPergunta(3, 'Quem libertou os escravos no Brasil?', ['Princesa Isabel'=>1, 'Dom Pedro I'=>0, 'Cristovão Colombo'=>0, 'Deodoro da Fonseca'=>0]);


            // ================= GEOGRAFIA (ID 4) =================
            $inserirPergunta(4, 'Qual é a capital do Brasil?', ['Rio de Janeiro'=>0, 'São Paulo'=>0, 'Brasília'=>1, 'Salvador'=>0]);
            $inserirPergunta(4, 'O Brasil fica em qual continente?', ['Europa'=>0, 'África'=>0, 'América do Sul'=>1, 'Ásia'=>0]);
            $inserirPergunta(4, 'Qual é o maior planeta do sistema solar?', ['Terra'=>0, 'Marte'=>0, 'Júpiter'=>1, 'Saturno'=>0]);
            $inserirPergunta(4, 'O Sol nasce no:', ['Leste'=>1, 'Oeste'=>0, 'Norte'=>0, 'Sul'=>0]);
            $inserirPergunta(4, 'Qual destes é um oceano?', ['Amazonas'=>0, 'Atlântico'=>1, 'Tietê'=>0, 'Nilo'=>0]);


            // ================= INGLÊS (ID 5) =================
            $inserirPergunta(5, 'Como se diz "Vermelho" em inglês?', ['Blue'=>0, 'Red'=>1, 'Green'=>0, 'Yellow'=>0]);
            $inserirPergunta(5, 'O que significa "Dog"?', ['Gato'=>0, 'Cachorro'=>1, 'Pássaro'=>0, 'Peixe'=>0]);
            $inserirPergunta(5, 'Como se diz "Bom dia" em inglês?', ['Good Night'=>0, 'Good Morning'=>1, 'Goodbye'=>0, 'Hello'=>0]);
            $inserirPergunta(5, 'Qual número é "Five"?', ['5'=>1, '4'=>0, '10'=>0, '1'=>0]);
            $inserirPergunta(5, 'Como se diz "Obrigado"?', ['Please'=>0, 'Sorry'=>0, 'Thank you'=>1, 'Welcome'=>0]);


            // ================= QUÍMICA (ID 6) =================
            $inserirPergunta(6, 'Qual é a fórmula da água?', ['CO2'=>0, 'H2O'=>1, 'O2'=>0, 'H2'=>0]);
            $inserirPergunta(6, 'O oxigênio é importante para:', ['Respirar'=>1, 'Comer'=>0, 'Dormir'=>0, 'Nenhuma das anteriores'=>0]);
            $inserirPergunta(6, 'O que acontece se aquecer a água a 100 graus?', ['Ela congela'=>0, 'Ela ferve/vira vapor'=>1, 'Ela fica sólida'=>0, 'Nada acontece'=>0]);
            $inserirPergunta(6, 'O símbolo "Au" representa qual metal?', ['Prata'=>0, 'Ouro'=>1, 'Ferro'=>0, 'Cobre'=>0]);
            $inserirPergunta(6, 'Tudo no mundo é formado por:', ['Átomos'=>1, 'Mágica'=>0, 'Vento'=>0, 'Plástico'=>0]);


            // ================= FÍSICA (ID 7) =================
            $inserirPergunta(7, 'O que nos mantêm presos ao chão?', ['Magnetismo'=>0, 'Gravidade'=>1, 'Eletricidade'=>0, 'Cola'=>0]);
            $inserirPergunta(7, 'O que é mais rápido?', ['O som'=>0, 'A luz'=>1, 'Um carro'=>0, 'Um avião'=>0]);
            $inserirPergunta(7, 'Para fazer um carro andar, precisamos de:', ['Energia/Combustível'=>1, 'Água'=>0, 'Vento'=>0, 'Areia'=>0]);
            $inserirPergunta(7, 'Se você soltar uma pena e uma bola, o que cai?', ['As duas sobem'=>0, 'As duas caem'=>1, 'Ficam paradas'=>0, 'A pena voa para o espaço'=>0]);
            $inserirPergunta(7, 'Imãs atraem:', ['Metais/Ferro'=>1, 'Plástico'=>0, 'Madeira'=>0, 'Vidro'=>0]);


            // ================= ARTES (ID 8) =================
            $inserirPergunta(8, 'Quais são as cores primárias?', ['Verde, Roxo e Laranja'=>0, 'Azul, Amarelo e Vermelho'=>1, 'Preto e Branco'=>0, 'Rosa e Cinza'=>0]);
            $inserirPergunta(8, 'O que usamos para pintar quadros?', ['Martelo'=>0, 'Pincel e Tinta'=>1, 'Colher'=>0, 'Chave de fenda'=>0]);
            $inserirPergunta(8, 'A mistura de Azul com Amarelo dá:', ['Roxo'=>0, 'Verde'=>1, 'Laranja'=>0, 'Marrom'=>0]);
            $inserirPergunta(8, 'Mona Lisa é uma pintura famosa de:', ['Picasso'=>0, 'Leonardo da Vinci'=>1, 'Van Gogh'=>0, 'Pelé'=>0]);
            $inserirPergunta(8, 'O que é uma escultura?', ['Um desenho no papel'=>0, 'Uma arte em 3D (barro, pedra)'=>1, 'Uma música'=>0, 'Um filme'=>0]);


            // ================= EDUCAÇÃO FÍSICA (ID 9) =================
            $inserirPergunta(9, 'No futebol, quem pode pegar a bola com a mão?', ['Atacante'=>0, 'Goleiro'=>1, 'Zagueiro'=>0, 'Juiz'=>0]);
            $inserirPergunta(9, 'Qual esporte usa uma cesta?', ['Futebol'=>0, 'Basquete'=>1, 'Vôlei'=>0, 'Natação'=>0]);
            $inserirPergunta(9, 'Para ter saúde é bom:', ['Ficar só no sofá'=>0, 'Praticar exercícios'=>1, 'Comer muito doce'=>0, 'Não dormir'=>0]);
            $inserirPergunta(9, 'As Olimpíadas acontecem de quanto em quanto tempo?', ['Todo ano'=>0, 'A cada 4 anos'=>1, 'A cada 10 anos'=>0, 'Nunca acontece'=>0]);
            $inserirPergunta(9, 'No Vôlei, quantos jogadores ficam em quadra por time?', ['2'=>0, '6'=>1, '11'=>0, '5'=>0]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Se precisar reverter, remove a coluna created_at/updated_at se tiver sido adicionada
        if (Schema::hasColumn('perguntas', 'created_at')) {
            Schema::table('perguntas', function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};