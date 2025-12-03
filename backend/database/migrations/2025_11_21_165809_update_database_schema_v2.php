<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. LIMPEZA DE DEPENDÊNCIAS ANTIGAS
        Schema::dropIfExists('alunos_has_conteudos');

        if (Schema::hasColumn('atividades', 'conteudo_id_conteudo')) {
            Schema::table('atividades', function (Blueprint $table) {
                $table->dropForeign(['conteudo_id_conteudo']);
                $table->dropColumn('conteudo_id_conteudo');
            });
        }

        if (Schema::hasColumn('modulos_ensino', 'nivel_ensino_id_nivel_ensino')) {
            Schema::table('modulos_ensino', function (Blueprint $table) {
                $table->dropForeign(['nivel_ensino_id_nivel_ensino']);
                $table->dropColumn('nivel_ensino_id_nivel_ensino');
            });
        }

        Schema::dropIfExists('conteudos');
        Schema::dropIfExists('niveis_ensino');


        // 2. CRIAR NOVA TABELA 'NIVEIS'
        Schema::create('niveis', function (Blueprint $table) {
            $table->id(); 
            $table->integer('nivel')->unique(); // Ex: 1, 2, 3
            $table->timestamps();
        });


        // 3. TRANSFORMAR 'ATIVIDADES' EM 'PERGUNTAS'
        Schema::rename('atividades', 'perguntas');

        Schema::table('perguntas', function (Blueprint $table) {
            $table->renameColumn('id_atividade', 'id');
            $table->renameColumn('pergunta', 'enunciado');
            $table->dropColumn('resposta'); 
            
            $table->unsignedBigInteger('professor_id_usuario');
            $table->foreign('professor_id_usuario')
                ->references('id_usuario')->on('professores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            if (Schema::hasColumn('perguntas', 'nivel')) {
                $table->dropColumn('nivel');
            }
            if (Schema::hasColumn('perguntas', 'modulo_ensino_id')) {
                $table->dropForeign(['modulo_ensino_id']);
                $table->dropColumn('modulo_ensino_id');
            }
        });


        // 4. ATUALIZAR TABELA ALUNOS
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('avatar')->default('/imgs/perfil/boy_black.webp');
            $table->string('borda')->default('padrao');
            $table->string('fundo')->default('padrao');
        });


        // 5. ATUALIZAR TABELA MODULOS_ENSINO
        if (Schema::hasColumn('modulos_ensino', 'nivel')) {
             Schema::table('modulos_ensino', function (Blueprint $table) {
                $table->dropColumn('nivel');
             });
        }


        // 6. ATUALIZAR TABELA ALUNOS_HAS_MODULOS_ENSINO (CORREÇÃO DO ERRO 1553)
        Schema::table('alunos_has_modulos_ensino', function (Blueprint $table) {
            // IMPORTANTE: Dropamos as FKs existentes primeiro para liberar o índice PRIMARY
            $table->dropForeign(['aluno_id_usuario']);
            $table->dropForeign(['modulo_ensino_id_modulo_ensino']);
            
            // Agora podemos dropar a PK sem erro
            $table->dropPrimary(['aluno_id_usuario', 'modulo_ensino_id_modulo_ensino']);
        });

        Schema::table('alunos_has_modulos_ensino', function (Blueprint $table) {
            // Adiciona coluna nivel_id
            $table->unsignedBigInteger('nivel_id')->default(1); 

            // Recriamos as FKs antigas + a nova FK de nível
            $table->foreign('aluno_id_usuario')->references('id_usuario')->on('alunos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('modulo_ensino_id_modulo_ensino')->references('id_modulo_ensino')->on('modulos_ensino')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nivel_id')->references('id')->on('niveis')->onDelete('cascade');

            // Criamos a nova PK composta com os 3 campos
            $table->primary(['aluno_id_usuario', 'modulo_ensino_id_modulo_ensino', 'nivel_id'], 'pk_alunos_modulos_niveis');
        });


        // 7. CRIAR TABELA DE RELACIONAMENTO TERNÁRIO
        Schema::create('modulo_nivel_perguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modulo_ensino_id');
            $table->unsignedBigInteger('nivel_id');
            $table->unsignedBigInteger('pergunta_id');

            $table->foreign('modulo_ensino_id')->references('id_modulo_ensino')->on('modulos_ensino')->onDelete('cascade');
            $table->foreign('nivel_id')->references('id')->on('niveis')->onDelete('cascade');
            $table->foreign('pergunta_id')->references('id')->on('perguntas')->onDelete('cascade');

            $table->timestamps();
        });


        // 8. CRIAR TABELA DE OPCOES
        Schema::create('opcoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pergunta_id');
            $table->string('texto_opcao', 255);
            $table->boolean('eh_correta')->default(false);

            $table->foreign('pergunta_id')->references('id')->on('perguntas')->onDelete('cascade');
            $table->timestamps();
        });


        // 9. CRIAR TABELA INTERMEDIÁRIA (ALUNOS <-> PERGUNTAS)
        Schema::create('alunos_has_perguntas', function (Blueprint $table) {
            $table->unsignedBigInteger('aluno_id_usuario');
            $table->unsignedBigInteger('pergunta_id');
            $table->string('status', 45)->default('pendente'); 

            $table->primary(['aluno_id_usuario', 'pergunta_id']);

            $table->foreign('aluno_id_usuario')->references('id_usuario')->on('alunos')->onDelete('cascade');
            $table->foreign('pergunta_id')->references('id')->on('perguntas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulo_nivel_perguntas');
        Schema::dropIfExists('alunos_has_perguntas');
        Schema::dropIfExists('opcoes');
        
        // Reverter Alunos Has Modulos
        if (Schema::hasColumn('alunos_has_modulos_ensino', 'nivel_id')) {
            Schema::table('alunos_has_modulos_ensino', function (Blueprint $table) {
                // Drop das novas chaves
                $table->dropForeign(['nivel_id']);
                $table->dropPrimary('pk_alunos_modulos_niveis');
                
                // Drop das FKs recriadas para limpar indices
                $table->dropForeign(['aluno_id_usuario']);
                $table->dropForeign(['modulo_ensino_id_modulo_ensino']);
                
                $table->dropColumn('nivel_id');
                
                // Restaura estrutura antiga
                $table->primary(['aluno_id_usuario', 'modulo_ensino_id_modulo_ensino']);
                $table->foreign('aluno_id_usuario')->references('id_usuario')->on('alunos')->onDelete('cascade');
                $table->foreign('modulo_ensino_id_modulo_ensino')->references('id_modulo_ensino')->on('modulos_ensino')->onDelete('cascade');
            });
        }

        Schema::dropIfExists('niveis');

        Schema::table('alunos', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'borda', 'fundo']);
        });

        Schema::table('perguntas', function (Blueprint $table) {
            $table->dropForeign(['professor_id_usuario']);
            $table->dropColumn('professor_id_usuario');
            $table->string('resposta', 255)->nullable();
            $table->renameColumn('enunciado', 'pergunta');
            $table->renameColumn('id', 'id_atividade');
        });
        Schema::rename('perguntas', 'atividades');

        Schema::create('niveis_ensino', function (Blueprint $table) { $table->id('id_nivel_ensino'); });
        Schema::create('conteudos', function (Blueprint $table) { $table->id('id_conteudo'); });
    }
};