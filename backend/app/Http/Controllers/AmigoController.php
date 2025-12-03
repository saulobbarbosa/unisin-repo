<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use Illuminate\Http\Request;

class AmigoController extends Controller
{
    public function index()
    {
        return response()->json(Amigo::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'aluno_id_usuario1' => 'required|integer|exists:alunos,id_usuario',
            'aluno_id_usuario2' => 'required|integer|exists:alunos,id_usuario',
        ]);

        $amigo = Amigo::create($data);
        return response()->json($amigo, 201);
    }

    public function show($id1, $id2)
    {
        $amigo = Amigo::where('aluno_id_usuario1', $id1)
                      ->where('aluno_id_usuario2', $id2)
                      ->firstOrFail();

        return response()->json($amigo);
    }

    public function update(Request $request, $id1, $id2)
    {
        $amigo = Amigo::where('aluno_id_usuario1', $id1)
                      ->where('aluno_id_usuario2', $id2)
                      ->firstOrFail();

        $data = $request->validate([
            'aluno_id_usuario1' => 'required|integer|exists:alunos,id_usuario',
            'aluno_id_usuario2' => 'required|integer|exists:alunos,id_usuario',
        ]);

        $amigo->update($data);
        return response()->json($amigo);
    }

    public function destroy($id1, $id2)
    {
        $amigo = Amigo::where('aluno_id_usuario1', $id1)
                      ->where('aluno_id_usuario2', $id2)
                      ->firstOrFail();

        $amigo->delete();
        return response()->json(null, 204);
    }
}
