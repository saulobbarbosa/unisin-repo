<?php

namespace App\Http\Controllers;

use App\Models\AlunoConquista;
use Illuminate\Http\Request;

class AlunoConquistaController extends Controller
{
    public function index()
    {
        $alunoConquistas = AlunoConquista::with(['aluno', 'conquista'])->get();
        return response()->json($alunoConquistas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aluno_id_usuario'      => 'required|integer|exists:alunos,id_usuario',
            'conquista_id_conquista'=> 'required|integer|exists:conquistas,id_conquista',
        ]);

        $existe = AlunoConquista::where('aluno_id_usuario', $validated['aluno_id_usuario'])
                                ->where('conquista_id_conquista', $validated['conquista_id_conquista'])
                                ->first();

        if ($existe) {
            return response()->json(['message' => 'Essa conquista já foi atribuída a esse aluno.'], 409);
        }

        $alunoConquista = AlunoConquista::create($validated);

        return response()->json([
            'message' => 'Conquista atribuída ao aluno com sucesso!',
            'alunoConquista' => $alunoConquista
        ], 201);
    }

    public function show($alunoId, $conquistaId)
    {
        $alunoConquista = AlunoConquista::where('aluno_id_usuario', $alunoId)
                                        ->where('conquista_id_conquista', $conquistaId)
                                        ->with(['aluno', 'conquista'])
                                        ->first();

        if (!$alunoConquista) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        return response()->json($alunoConquista);
    }

    public function destroy($alunoId, $conquistaId)
    {
        $alunoConquista = AlunoConquista::where('aluno_id_usuario', $alunoId)
                                        ->where('conquista_id_conquista', $conquistaId)
                                        ->first();

        if (!$alunoConquista) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        $alunoConquista->delete();

        return response()->json(['message' => 'Conquista removida do aluno com sucesso!']);
    }
}

