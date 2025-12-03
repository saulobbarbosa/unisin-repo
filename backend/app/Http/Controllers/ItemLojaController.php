<?php

namespace App\Http\Controllers;

use App\Models\ItemLoja;
use App\Models\AlunoItemLoja;
use Illuminate\Http\Request;

class ItemLojaController extends Controller
{
    /**
     * Lista padrão (Admin ou sem contexto de aluno).
     */
    public function index()
    {
        return response()->json(ItemLoja::all());
    }

    /**
     * Lista itens da loja com status para um aluno específico.
     * Rota: GET /itens-loja/aluno/{alunoId}
     */
    public function listarParaAluno($alunoId)
    {
        $itens = ItemLoja::all();

        // Busca os IDs dos itens que esse aluno já tem
        $itensCompradosIds = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
            ->pluck('item_loja_id_item_loja')
            ->toArray();

        // Percorre a lista de itens e adiciona o status
        $itens->map(function ($item) use ($itensCompradosIds) {
            if (in_array($item->id_item_loja, $itensCompradosIds)) {
                $item->status = 'comprado';
            } else {
                $item->status = 'disponivel';
            }
            return $item;
        });

        return response()->json($itens);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:255',
            'preco'    => 'required|numeric',
            'conteudo' => 'required|string|max:255',
            'tipo'     => 'required|string|max:255',
        ]);

        $item = ItemLoja::create($data);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = ItemLoja::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = ItemLoja::findOrFail($id);

        $data = $request->validate([
            'nome'     => 'sometimes|string|max:255',
            'preco'    => 'sometimes|numeric',
            'conteudo' => 'sometimes|string|max:255',
            'tipo'     => 'sometimes|string|max:255',
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = ItemLoja::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}