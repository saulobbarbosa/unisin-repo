<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Trigger para INSERÇÃO (Primeira vez que responde)
        DB::unprepared('DROP TRIGGER IF EXISTS trg_moedas_aluno_insert');
        
        DB::unprepared("
            CREATE TRIGGER trg_moedas_aluno_insert
            AFTER INSERT ON alunos_has_perguntas
            FOR EACH ROW
            BEGIN
                -- Se a resposta for correta, adiciona 500 moedas
                IF NEW.status = 'correto' THEN
                    UPDATE alunos 
                    SET moedas = moedas + 500 
                    WHERE id_usuario = NEW.aluno_id_usuario;
                
                -- Se a resposta for incorreta, retira 600 moedas
                ELSEIF NEW.status = 'errado' THEN
                    UPDATE alunos 
                    SET moedas = moedas - 600 
                    WHERE id_usuario = NEW.aluno_id_usuario;
                END IF;
            END
        ");

        // 2. Trigger para ATUALIZAÇÃO (Caso mude a resposta)
        DB::unprepared('DROP TRIGGER IF EXISTS trg_moedas_aluno_update');

        DB::unprepared("
            CREATE TRIGGER trg_moedas_aluno_update
            AFTER UPDATE ON alunos_has_perguntas
            FOR EACH ROW
            BEGIN
                -- Só executa se realmente mudou o status
                IF NEW.status <> OLD.status THEN
                    
                    IF NEW.status = 'correto' THEN
                        UPDATE alunos
                        SET moedas = moedas + 500
                        WHERE id_usuario = NEW.aluno_id_usuario;

                    ELSEIF NEW.status = 'errado' THEN
                        UPDATE alunos
                        SET moedas = moedas - 600
                        WHERE id_usuario = NEW.aluno_id_usuario;
                    END IF;

                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_moedas_aluno_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_moedas_aluno_update');
    }
};