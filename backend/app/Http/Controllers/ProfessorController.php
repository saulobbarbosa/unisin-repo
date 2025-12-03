<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        return response()->json(Professor::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario'     => 'required|integer|exists:usuarios,id_usuario',
            'escola_id_escola' => 'required|integer|exists:escolas,id_escola',
        ]);

        $professor = Professor::create($data);
        return response()->json($professor, 201);
    }

    public function show($id)
    {
        $professor = Professor::findOrFail($id);
        return response()->json($professor);
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);

        $data = $request->validate([
            'id_usuario'     => 'required|integer|exists:usuarios,id_usuario',
            'escola_id_escola' => 'required|integer|exists:escolas,id_escola',
        ]);

        $professor->update($data);
        return response()->json($professor);
    }

    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->delete();
        return response()->json(null, 204);
    }
}
