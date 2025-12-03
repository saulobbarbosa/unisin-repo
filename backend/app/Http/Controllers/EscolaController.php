<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;

class EscolaController extends Controller
{
    public function index()
    {
        return response()->json(Escola::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'cep'        => 'required|string|max:20',
            'rua'        => 'required|string|max:255',
            'cidade'     => 'required|string|max:255',
            'estado'     => 'required|string|max:255',
            'id_usuario' => 'required|integer|exists:usuarios,id_usuario',
        ]);

        $escola = Escola::create($data);
        return response()->json($escola, 201);
    }

    public function show($id)
    {
        $escola = Escola::findOrFail($id);
        return response()->json($escola);
    }

    public function update(Request $request, $id)
    {
        $escola = Escola::findOrFail($id);

        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'cep'        => 'required|string|max:20',
            'rua'        => 'required|string|max:255',
            'cidade'     => 'required|string|max:255',
            'estado'     => 'required|string|max:255',
            'id_usuario' => 'required|integer|exists:usuarios,id_usuario',
        ]);

        $escola->update($data);
        return response()->json($escola);
    }

    public function destroy($id)
    {
        $escola = Escola::findOrFail($id);
        $escola->delete();
        return response()->json(null, 204);
    }
}
