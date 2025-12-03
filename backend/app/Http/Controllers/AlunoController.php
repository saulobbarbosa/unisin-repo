<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AlunoModuloEnsino; // Import necessário para buscar as matrículas
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('usuario')->get();
        return response()->json($alunos);
    }

    /**
     * Retorna dados do aluno + nome do usuário + Nível Médio
     * Rota: GET /alunos/{id}/dados
     */
    public function getDadosCompletos($id)
    {
        // 1. Busca o aluno e carrega o relacionamento 'usuario'
        $aluno = Aluno::with('usuario')->find($id);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        // 2. CÁLCULO DO NÍVEL MÉDIO
        // Busca todas as matrículas do aluno trazendo o objeto Nivel associado
        $matriculas = AlunoModuloEnsino::where('aluno_id_usuario', $id)
                                       ->with('nivel')
                                       ->get();

        // Soma os valores inteiros dos níveis (ex: 1+1+2+1...)
        $somaNiveis = $matriculas->sum(function ($matricula) {
            return $matricula->nivel ? $matricula->nivel->nivel : 0;
        });

        $totalMaterias = $matriculas->count();

        // Calcula a média e arredonda (round). Se não tiver matérias, define como 1.
        $nivelMedio = $totalMaterias > 0 ? round($somaNiveis / $totalMaterias) : 1;

        // 3. Monta a resposta formatada
        $dados = [
            'id'     => $aluno->id_usuario,
            'nome'   => $aluno->usuario->nome, // Vem da tabela usuarios
            'moedas' => $aluno->moedas,
            'avatar' => $aluno->avatar,
            'borda'  => $aluno->borda,
            'fundo'  => $aluno->fundo,
            'nivel'  => (int) $nivelMedio, // Novo campo calculado
        ];

        return response()->json($dados);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario' => 'required|integer|unique:alunos,id_usuario',
            'moedas' => 'required|integer|min:0',
        ]);

        $aluno = Aluno::create($validated);

        return response()->json([
            'message' => 'Aluno criado com sucesso!',
            'aluno' => $aluno
        ], 201);
    }

    public function show($id)
    {
        $aluno = Aluno::with('usuario')->find($id);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        return response()->json($aluno);
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        $validated = $request->validate([
            'moedas' => 'sometimes|integer|min:0',
            'avatar' => 'sometimes|string|max:255',
            'borda'  => 'sometimes|string|max:255',
            'fundo'  => 'sometimes|string|max:255',
        ]);

        $aluno->update($validated);

        return response()->json([
            'message' => 'Aluno atualizado com sucesso!',
            'aluno' => $aluno
        ]);
    }

    public function destroy($id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado'], 404);
        }

        $aluno->delete();

        return response()->json(['message' => 'Aluno removido com sucesso!']);
    }
}