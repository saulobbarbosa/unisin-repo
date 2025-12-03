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
        // 1. INSERIR NÍVEIS (1 a 5)
        // Usamos insertOrIgnore para evitar erros se rodar duas vezes
        $niveis = [1, 2, 3, 4, 5];
        foreach ($niveis as $nivel) {
            DB::table('niveis')->insertOrIgnore([
                'nivel' => $nivel,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. INSERIR MATÉRIAS (MÓDULOS)
        $materias = [
            'Matemática',
            'Português',
            'História',
            'Geografia',
            'Inglês',
            'Química',
            'Física',
            'Artes',
            'Educação Física'
        ];

        foreach ($materias as $nome) {
            DB::table('modulos_ensino')->insertOrIgnore([
                'nome' => $nome
                // timestamps removidos pois a tabela modulos_ensino não os tem na definição original
            ]);
        }

        // 3. CRIAR O TRIGGER
        // O Trigger dispara APÓS um insert na tabela 'alunos'.
        // Ele seleciona o ID do nível 1.
        // Ele seleciona TODOS os IDs das matérias disponíveis.
        // Ele insere registros na tabela pivô vinculando o NOVO aluno (NEW.id_usuario) a todas as matérias no nível 1.

        DB::unprepared('DROP TRIGGER IF EXISTS trg_auto_matricular_aluno');

        DB::unprepared("
            CREATE TRIGGER trg_auto_matricular_aluno
            AFTER INSERT ON alunos
            FOR EACH ROW
            BEGIN
                -- Variável para guardar o ID do nível 1
                DECLARE id_nivel_1 BIGINT;

                -- Busca o ID da tabela 'niveis' onde o valor da coluna 'nivel' é 1
                SELECT id INTO id_nivel_1 FROM niveis WHERE nivel = 1 LIMIT 1;

                -- Insere o relacionamento para cada matéria existente
                IF id_nivel_1 IS NOT NULL THEN
                    INSERT INTO alunos_has_modulos_ensino (aluno_id_usuario, modulo_ensino_id_modulo_ensino, nivel_id)
                    SELECT 
                        NEW.id_usuario,       -- ID do aluno recém criado
                        m.id_modulo_ensino,   -- ID da matéria
                        id_nivel_1            -- ID do nível 1
                    FROM modulos_ensino m;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Apagar o Trigger
        DB::unprepared('DROP TRIGGER IF EXISTS trg_auto_matricular_aluno');

        // 2. Limpar os dados inseridos (Opcional, mas recomendado para rollback limpo)
        // Cuidado: Isso apagará níveis e módulos criados, e por cascade, as perguntas associadas.
        
        // Se quiser apenas remover o trigger, comente as linhas abaixo.
        
        /*
        $materias = [
            'Matemática', 'Português', 'História', 'Geografia', 
            'Inglês', 'Química', 'Física', 'Artes', 'Educação Física'
        ];
        DB::table('modulos_ensino')->whereIn('nome', $materias)->delete();
        
        $niveis = [1, 2, 3, 4, 5];
        DB::table('niveis')->whereIn('nivel', $niveis)->delete();
        */
    }
};