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
        // 1. INSERIR O NOVO ITEM NA LOJA
        // Verifica se já existe para não duplicar
        $existe = DB::table('itens_loja')->where('nome', 'Avatar Moreno')->exists();
        
        if (!$existe) {
            DB::table('itens_loja')->insert([
                'nome' => 'Avatar Moreno',
                'preco' => 1500.00,
                'conteudo' => '/imgs/perfil/boy_black.webp',
                'tipo' => 'avatar'
            ]);
        }

        // 2. CRIAR TRIGGER PARA DAR O ITEM A NOVOS ALUNOS
        // O trigger vai disparar APÓS um INSERT na tabela 'alunos'.
        // Ele vai pegar o ID do item 'Avatar Moreno' e inserir um registro na tabela 'alunos_has_itens_loja'.

        DB::unprepared('DROP TRIGGER IF EXISTS trg_dar_avatar_inicial');

        DB::unprepared("
            CREATE TRIGGER trg_dar_avatar_inicial
            AFTER INSERT ON alunos
            FOR EACH ROW
            BEGIN
                DECLARE id_avatar_moreno BIGINT;

                -- Busca o ID do item recém-criado
                SELECT id_item_loja INTO id_avatar_moreno 
                FROM itens_loja 
                WHERE nome = 'Avatar Moreno' 
                LIMIT 1;

                -- Se o item existir, insere na tabela de posse do aluno
                IF id_avatar_moreno IS NOT NULL THEN
                    INSERT INTO alunos_has_itens_loja (aluno_id_usuario, item_loja_id_item_loja)
                    VALUES (NEW.id_usuario, id_avatar_moreno);
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove o trigger
        DB::unprepared('DROP TRIGGER IF EXISTS trg_dar_avatar_inicial');

        // Remove o item (Opcional, cuidado ao rodar em produção se alunos já compraram)
        // DB::table('itens_loja')->where('nome', 'Avatar Moreno')->delete();
    }
};