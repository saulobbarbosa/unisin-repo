<?php

namespace App\Http\Controllers;

use App\Models\AlunoPergunta;
use Illuminate\Http\Request;

class AlunoPerguntaController extends Controller
{
    public function index()
    {
        // Listar todo histórico
        return response()->json(AlunoPergunta::with(['aluno.usuario', 'pergunta'])->get());
    }

    // Registrar que um aluno respondeu ou visualizou (Método Genérico)
    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'aluno_id_usuario' => 'required|integer|exists:alunos,id_usuario',
            'pergunta_id'      => 'required|integer|exists:perguntas,id',
            'status'           => 'required|string',
        ]);

        // Atualiza se existir a combinação aluno+pergunta, ou cria novo
        $registro = AlunoPergunta::updateOrCreate(
            [
                'aluno_id_usuario' => $validated['aluno_id_usuario'],
                'pergunta_id'      => $validated['pergunta_id']
            ],
            [
                'status' => $validated['status']
            ]
        );

        return response()->json([
            'message' => 'Status da pergunta atualizado com sucesso.',
            'data'    => $registro
        ], 200);
    }

    public function show($alunoId, $perguntaId)
    {
        $registro = AlunoPergunta::where('aluno_id_usuario', $alunoId)
                                 ->where('pergunta_id', $perguntaId)
                                 ->first();

        if (!$registro) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        return response()->json($registro);
    }
}