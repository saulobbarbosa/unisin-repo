<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\Aluno;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Busca o usuário pelo email
        $usuario = Usuario::where('email', $request->email)->first();

        // 2. Verifica se o usuário existe E se a senha está correta
        if (! $usuario || ! Hash::check($request->senha, $usuario->senha)) {
            return response()->json([
                'success' => false,
                'message' => 'As credenciais fornecidas estão incorretas.'
            ], 401);
        }

        // 3. Se tudo estiver certo, cria e retorna um token para o usuário
        $token = $usuario->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso.',
            'usuario' => $usuario,
            'token' => $token
        ]);
    }

        public function register(Request $request)
    {
        try {

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'dt_nasc' => 'required|date',
                'email' => 'required|string|email|max:255|unique:usuarios,email',
                'senha' => 'required|string|min:6',
                'telefone' => 'required|string|max:15|unique:usuarios,telefone',
            ]);

    
            $aluno = DB::transaction(function () use ($validated) {

                
                $usuario = Usuario::create([
                    'nome' => $validated['nome'],
                    'dt_nasc' => $validated['dt_nasc'],
                    'email' => $validated['email'],
                    'senha' => bcrypt($validated['senha']),
                    'telefone' => $validated['telefone'],
                ]);

                
                $aluno = Aluno::create([
                    'id_usuario' => $usuario->id_usuario, 
                    'moedas' => 0,
                ]);

                return $aluno;
            });

            
            return response()->json([
                'message' => 'Aluno cadastrado com sucesso!',
                'aluno' => $aluno
            ], 201);

        } catch (ValidationException $e) {
            
            return response()->json([
                'error' => 'Dados inválidos fornecidos.',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            
            return response()->json([
                'error' => 'Ocorreu um erro inesperado ao cadastrar o aluno.',
                'message' => $e->getMessage() 
            ], 500);
        }
    }

}