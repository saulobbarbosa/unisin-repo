<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use App\Models\Opcao;
use App\Models\ModuloNivelPergunta;
use App\Models\Nivel;
use App\Models\AlunoPergunta; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerguntaController extends Controller
{
    public function index()
    {
        return response()->json(Pergunta::with(['opcoes', 'contexto.modulo', 'contexto.nivel'])->get());
    }

    /**
     * QUIZ: Retorna a LISTA de IDs das perguntas filtradas por Modulo e Nivel com o STATUS.
     * Rota: GET /api/quiz/{id_modulo}/{nivel}/{id_aluno}
     * Parametros: id_modulo (int), nivel (int - numero visual), id_aluno (int)
     * Retorno: Lista leve com IDs e Status.
     */
    public function quiz($id_modulo, $numero_nivel, $id_aluno)
    {
        // 1. Descobrir o ID do nível baseado no número visual (ex: Nível 1, Nível 2)
        $nivelModel = Nivel::where('nivel', $numero_nivel)->first();

        if (!$nivelModel) {
            return response()->json([]);
        }

        // 2. Busca na tabela DE RELACIONAMENTO (ModuloNivelPergunta)
        // Filtra pelo módulo e pelo ID real do nível encontrado
        $relacoes = ModuloNivelPergunta::where('modulo_ensino_id', $id_modulo)
                                       ->where('nivel_id', $nivelModel->id)
                                       ->get();

        if ($relacoes->isEmpty()) {
            return response()->json([]);
        }

        // 3. Buscar o status das perguntas para ESTE aluno
        $perguntasIds = $relacoes->pluck('pergunta_id');

        $statusMap = AlunoPergunta::where('aluno_id_usuario', $id_aluno)
                                  ->whereIn('pergunta_id', $perguntasIds)
                                  ->pluck('status', 'pergunta_id'); 

        // 4. Formata a saída simplificada (ID + Status)
        $formatadas = $relacoes->map(function ($relacao) use ($numero_nivel, $statusMap) {
            
            $perguntaId = $relacao->pergunta_id;
            $statusAluno = $statusMap[$perguntaId] ?? 'pendente';

            return [
                'id'        => $perguntaId,
                'modulo_id' => $relacao->modulo_ensino_id,
                'nivel'     => (int)$numero_nivel,
                'status'    => $statusAluno
            ];
        });

        return response()->json($formatadas->values());
    }

    /**
     * Retorna os detalhes de UMA pergunta específica para jogar.
     * Rota: GET /api/perguntas/{id}/jogar
     */
    public function getDetalhesPergunta($id)
    {
        $pergunta = Pergunta::with('opcoes')->findOrFail($id);

        $opcaoCorreta = $pergunta->opcoes->where('eh_correta', true)->first();

        return response()->json([
            'pergunta'  => $pergunta->enunciado,
            'respostas' => $pergunta->opcoes->pluck('texto_opcao')->values()->toArray(),
            'correta'   => $opcaoCorreta ? $opcaoCorreta->texto_opcao : null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enunciado' => 'required|string',
            'tipo' => 'required|string',
            'professor_id_usuario' => 'required|integer|exists:professores,id_usuario',
            
            'modulo_ensino_id' => 'required|integer|exists:modulos_ensino,id_modulo_ensino',
            'nivel_id' => 'required|integer|exists:niveis,id',
            
            'opcoes' => 'array|min:1', 
            'opcoes.*.texto_opcao' => 'required|string',
            'opcoes.*.eh_correta' => 'boolean',
        ]);

        $pergunta = DB::transaction(function () use ($validated) {
            $pergunta = Pergunta::create([
                'enunciado' => $validated['enunciado'],
                'tipo' => $validated['tipo'],
                'professor_id_usuario' => $validated['professor_id_usuario'],
            ]);

            ModuloNivelPergunta::create([
                'modulo_ensino_id' => $validated['modulo_ensino_id'],
                'nivel_id' => $validated['nivel_id'],
                'pergunta_id' => $pergunta->id
            ]);

            if (isset($validated['opcoes'])) {
                foreach ($validated['opcoes'] as $opcaoData) {
                    Opcao::create([
                        'pergunta_id' => $pergunta->id,
                        'texto_opcao' => $opcaoData['texto_opcao'],
                        'eh_correta' => $opcaoData['eh_correta'] ?? false,
                    ]);
                }
            }
            return $pergunta;
        });

        return response()->json($pergunta->load(['opcoes', 'contexto']), 201);
    }

    public function show($id)
    {
        $pergunta = Pergunta::with(['opcoes', 'contexto'])->findOrFail($id);
        return response()->json($pergunta);
    }

    public function update(Request $request, $id)
    {
        $pergunta = Pergunta::findOrFail($id);

        $validated = $request->validate([
            'enunciado' => 'sometimes|string',
            'tipo' => 'sometimes|string',
            'modulo_ensino_id' => 'sometimes|integer|exists:modulos_ensino,id_modulo_ensino',
            'nivel_id' => 'sometimes|integer|exists:niveis,id',
        ]);

        $pergunta->update($request->only(['enunciado', 'tipo']));

        if ($request->has('modulo_ensino_id') || $request->has('nivel_id')) {
            $contexto = ModuloNivelPergunta::where('pergunta_id', $pergunta->id)->first();
            
            if ($contexto) {
                $contexto->update($request->only(['modulo_ensino_id', 'nivel_id']));
            } else {
                 if ($request->has('modulo_ensino_id') && $request->has('nivel_id')) {
                    ModuloNivelPergunta::create([
                        'modulo_ensino_id' => $request->modulo_ensino_id,
                        'nivel_id' => $request->nivel_id,
                        'pergunta_id' => $pergunta->id
                    ]);
                 }
            }
        }

        return response()->json($pergunta->load(['opcoes', 'contexto']));
    }

    public function destroy($id)
    {
        $pergunta = Pergunta::findOrFail($id);
        $pergunta->delete(); 
        return response()->json(null, 204);
    }
}