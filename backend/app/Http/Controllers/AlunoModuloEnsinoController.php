<?php

namespace App\Http\Controllers;

use App\Models\AlunoModuloEnsino;
use App\Models\ModuloNivelPergunta; // Import necessário
use App\Models\AlunoPergunta;       // Import necessário
use Illuminate\Http\Request;

class AlunoModuloEnsinoController extends Controller
{
    public function index()
    {
        // Carrega Aluno, Módulo e agora Nível
        $alunoModulos = AlunoModuloEnsino::with(['aluno', 'moduloEnsino', 'nivel'])->get();
        return response()->json($alunoModulos);
    }

    /**
     * Retorna os módulos e o nível (número) que o aluno está.
     * Rota: /alunos/{id}/modulos
     */
    public function modulosPorAluno($alunoId)
    {
        $registros = AlunoModuloEnsino::where('aluno_id_usuario', $alunoId)
            ->with(['moduloEnsino', 'nivel'])
            ->get();

        $formatado = $registros->map(function ($item) {
            return [
                'id_modulo'   => $item->modulo_ensino_id_modulo_ensino,
                'nome_modulo' => $item->moduloEnsino->nome,
                'nivel'       => $item->nivel->nivel 
            ];
        });

        return response()->json($formatado);
    }

    /**
     * Retorna o progresso do aluno em cada matéria
     * Rota: GET /alunos/{id}/progresso
     */
    public function getProgresso($alunoId)
    {
        // 1. Busca todas as matrículas do aluno
        $matriculas = AlunoModuloEnsino::where('aluno_id_usuario', $alunoId)
            ->with(['moduloEnsino'])
            ->get();

        $progresso = $matriculas->map(function ($matricula) use ($alunoId) {
            $moduloId = $matricula->modulo_ensino_id_modulo_ensino;
            $nivelId  = $matricula->nivel_id;

            // 2. Busca todas as perguntas disponíveis para esse Módulo naquele Nível
            // (Usando a tabela de relacionamento ternário)
            $idsPerguntasDoNivel = ModuloNivelPergunta::where('modulo_ensino_id', $moduloId)
                ->where('nivel_id', $nivelId)
                ->pluck('pergunta_id'); // Retorna apenas uma lista de IDs [1, 5, 9...]

            $totalPerguntas = $idsPerguntasDoNivel->count();

            // 3. Conta quantas dessas perguntas o aluno já respondeu
            // Consideramos "realizada" se o status for diferente de 'pendente'
            $realizadas = AlunoPergunta::where('aluno_id_usuario', $alunoId)
                ->whereIn('pergunta_id', $idsPerguntasDoNivel)
                ->where('status', '!=', 'pendente')
                ->count();

            return [
                'materia'    => $matricula->moduloEnsino->nome,
                'total_p'    => $totalPerguntas,
                'realizadas' => $realizadas
            ];
        });

        return response()->json($progresso);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aluno_id_usuario'               => 'required|integer|exists:alunos,id_usuario',
            'modulo_ensino_id_modulo_ensino' => 'required|integer|exists:modulos_ensino,id_modulo_ensino',
            'nivel_id'                       => 'required|integer|exists:niveis,id',
        ]);

        // Verifica se já existe a combinação Aluno + Módulo + Nível
        $existe = AlunoModuloEnsino::where('aluno_id_usuario', $validated['aluno_id_usuario'])
                                   ->where('modulo_ensino_id_modulo_ensino', $validated['modulo_ensino_id_modulo_ensino'])
                                   ->where('nivel_id', $validated['nivel_id'])
                                   ->first();

        if ($existe) {
            return response()->json(['message' => 'Este módulo neste nível já foi atribuído a este aluno.'], 409);
        }

        $alunoModulo = AlunoModuloEnsino::create($validated);

        return response()->json([
            'message' => 'Módulo e Nível atribuídos ao aluno com sucesso!',
            'alunoModulo' => $alunoModulo
        ], 201);
    }

    // Agora precisamos de 3 parâmetros para identificar unicamente
    public function show($alunoId, $moduloId, $nivelId)
    {
        $alunoModulo = AlunoModuloEnsino::where('aluno_id_usuario', $alunoId)
                                        ->where('modulo_ensino_id_modulo_ensino', $moduloId)
                                        ->where('nivel_id', $nivelId)
                                        ->with(['aluno', 'moduloEnsino', 'nivel'])
                                        ->first();

        if (!$alunoModulo) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        return response()->json($alunoModulo);
    }

    public function destroy($alunoId, $moduloId, $nivelId)
    {
        $alunoModulo = AlunoModuloEnsino::where('aluno_id_usuario', $alunoId)
                                        ->where('modulo_ensino_id_modulo_ensino', $moduloId)
                                        ->where('nivel_id', $nivelId)
                                        ->first();

        if (!$alunoModulo) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        $alunoModulo->delete();

        return response()->json(['message' => 'Registro removido com sucesso!']);
    }
}