<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(Usuario::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'dt_nasc' => 'required|date',
            'email' => 'required|string|email|max:255|unique:usuarios,email',
            'senha' => 'required|string|min:6',
            'telefone' => 'required|string|max:15|unique:usuarios,telefone',
        ]);

        // Criptografa a senha antes de criar o usuário
        $data['senha'] = bcrypt($data['senha']);

        $usuario = Usuario::create($data);
        return response()->json($usuario, 201);
    }


    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'dt_nasc' => 'required|date',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id . ',id_usuario',
            'senha' => 'required|string|min:6',
            'telefone' => 'required|string|max:15|unique:usuarios,telefone,' . $id . ',id_usuario',
        ]);
        $data['senha'] = bcrypt($data['senha']);

        $usuario->update($data);
        return response()->json($usuario);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(null, 204);
    }
}
