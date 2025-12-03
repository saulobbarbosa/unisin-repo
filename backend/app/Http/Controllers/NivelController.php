<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        return response()->json(Nivel::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => 'required|integer|unique:niveis,nivel',
        ]);

        $nivel = Nivel::create($validated);
        return response()->json($nivel, 201);
    }

    public function show($id)
    {
        return response()->json(Nivel::findOrFail($id));
    }

    public function destroy($id)
    {
        $nivel = Nivel::findOrFail($id);
        $nivel->delete();
        return response()->json(null, 204);
    }
}