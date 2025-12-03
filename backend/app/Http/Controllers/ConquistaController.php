<?php

namespace App\Http\Controllers;

use App\Models\Conquista;
use Illuminate\Http\Request;

class ConquistaController extends Controller
{
    public function index()
    {
        return response()->json(Conquista::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_conquista' => 'required|string|max:255',
        ]);

        $conquista = Conquista::create($data);
        return response()->json($conquista, 201);
    }

    public function show($id)
    {
        $conquista = Conquista::findOrFail($id);
        return response()->json($conquista);
    }

    public function update(Request $request, $id)
    {
        $conquista = Conquista::findOrFail($id);

        $data = $request->validate([
            'nome_conquista' => 'required|string|max:255',
        ]);

        $conquista->update($data);
        return response()->json($conquista);
    }

    public function destroy($id)
    {
        $conquista = Conquista::findOrFail($id);
        $conquista->delete();
        return response()->json(null, 204);
    }
}
