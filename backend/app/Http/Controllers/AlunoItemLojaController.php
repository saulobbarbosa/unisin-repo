<?php

namespace App\Http\Controllers;

use App\Models\AlunoItemLoja;
use App\Models\Aluno;
use App\Models\ItemLoja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunoItemLojaController extends Controller
{
    public function index()
    {
        $alunoItens = AlunoItemLoja::with(['aluno', 'itemLoja'])->get();
        return response()->json($alunoItens);
    }

    /**
     * Retorna somente os itens que o usuário tem.
     * Rota: GET /alunos/{id}/itens
     */
    public function itensPorAluno($alunoId)
    {
        // Busca os relacionamentos e carrega os dados do item da loja
        $itensDoAluno = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
                                     ->with('itemLoja')
                                     ->get();

        // Formata para retornar uma lista limpa dos itens
        $formatado = $itensDoAluno->map(function ($registro) {
            return $registro->itemLoja; 
        });

        return response()->json($formatado);
    }

    /**
     * Realiza a compra (APENAS COMPRA, NÃO EQUIPA).
     * Rota: POST /loja/comprar/{alunoId}/{itemId}
     */
    public function comprarItem($alunoId, $itemId)
    {
        // 1. Buscar Aluno e Item
        $aluno = Aluno::find($alunoId);
        $item  = ItemLoja::find($itemId);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado.'], 404);
        }

        if (!$item) {
            return response()->json(['message' => 'Item não encontrado.'], 404);
        }

        // 2. Verificar se já possui o item
        $jaPossui = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
                                 ->where('item_loja_id_item_loja', $itemId)
                                 ->exists();

        if ($jaPossui) {
            return response()->json(['message' => 'Aluno já possui este item.'], 409);
        }

        // 3. Verificar se tem moedas suficientes
        if ($aluno->moedas < $item->preco) {
            return response()->json([
                'message' => 'Saldo insuficiente.',
                'saldo_atual' => $aluno->moedas,
                'preco_item' => $item->preco
            ], 400); 
        }

        // 4. Transação: Descontar moedas + Registrar compra
        try {
            DB::transaction(function () use ($aluno, $item) {
                // A. Desconta as moedas
                $aluno->moedas -= $item->preco;
                $aluno->save();

                // B. Registrar a compra (tabela de relacionamento)
                // OBS: Removemos a parte que alterava 'avatar', 'borda', etc.
                AlunoItemLoja::create([
                    'aluno_id_usuario' => $aluno->id_usuario,
                    'item_loja_id_item_loja' => $item->id_item_loja
                ]);
            });

            return response()->json([
                'message' => 'Compra realizada com sucesso!',
                'saldo_restante' => $aluno->moedas,
                'item_comprado' => $item->nome
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao processar a compra.', 'error' => $e->getMessage()], 500);
        }
    }

    public function equiparItem($alunoId, $itemId)
    {
        // 1. Verificar se o aluno realmente possui este item
        $posse = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
                              ->where('item_loja_id_item_loja', $itemId)
                              ->first();

        if (!$posse) {
            return response()->json(['message' => 'Você não possui este item para equipar.'], 403); // Forbidden
        }

        $aluno = Aluno::find($alunoId);
        $item  = ItemLoja::find($itemId);

        if (!$aluno || !$item) {
            return response()->json(['message' => 'Aluno ou Item não encontrado.'], 404);
        }

        // 2. Atualizar o campo correto no Aluno com base no tipo do Item
        // Tipos esperados: 'borda', 'fundo', 'avatar'
        switch ($item->tipo) {
            case 'borda':
                $aluno->borda = $item->conteudo;
                break;
            case 'fundo':
                $aluno->fundo = $item->conteudo;
                break;
            case 'avatar':
                $aluno->avatar = $item->conteudo;
                break;
            default:
                return response()->json(['message' => 'Tipo de item desconhecido, não foi possível equipar.'], 400);
        }

        $aluno->save();

        return response()->json([
            'message' => 'Item equipado com sucesso!',
            'tipo' => $item->tipo,
            'novo_valor' => $item->conteudo
        ]);
    }

    public function itensEquipados($alunoId)
    {
        $aluno = Aluno::find($alunoId);

        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado.'], 404);
        }

        $equipados = [
            'avatar' => null,
            'borda'  => null,
            'fundo'  => null
        ];

        // Busca o nome do item de Avatar
        if ($aluno->avatar && $aluno->avatar !== 'padrao') {
            $itemAvatar = ItemLoja::where('tipo', 'avatar')
                                  ->where('conteudo', $aluno->avatar)
                                  ->first();
            $equipados['avatar'] = $itemAvatar ? $itemAvatar->nome : 'Item Desconhecido';
        } else {
            $equipados['avatar'] = 'Padrão';
        }

        // Busca o nome do item de Borda
        if ($aluno->borda && $aluno->borda !== 'padrao') {
            $itemBorda = ItemLoja::where('tipo', 'borda')
                                 ->where('conteudo', $aluno->borda)
                                 ->first();
            $equipados['borda'] = $itemBorda ? $itemBorda->nome : 'Item Desconhecido';
        } else {
            $equipados['borda'] = 'Padrão';
        }

        // Busca o nome do item de Fundo
        if ($aluno->fundo && $aluno->fundo !== 'padrao') {
            $itemFundo = ItemLoja::where('tipo', 'fundo')
                                 ->where('conteudo', $aluno->fundo)
                                 ->first();
            $equipados['fundo'] = $itemFundo ? $itemFundo->nome : 'Item Desconhecido';
        } else {
            $equipados['fundo'] = 'Padrão';
        }

        return response()->json($equipados);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aluno_id_usuario'        => 'required|integer|exists:alunos,id_usuario',
            'item_loja_id_item_loja'  => 'required|integer|exists:itens_loja,id_item_loja',
        ]);

        $existe = AlunoItemLoja::where('aluno_id_usuario', $validated['aluno_id_usuario'])
                               ->where('item_loja_id_item_loja', $validated['item_loja_id_item_loja'])
                               ->first();

        if ($existe) {
            return response()->json(['message' => 'Esse item já foi atribuído a esse aluno.'], 409);
        }

        $alunoItem = AlunoItemLoja::create($validated);

        return response()->json([
            'message' => 'Item atribuído ao aluno com sucesso!',
            'alunoItem' => $alunoItem
        ], 201);
    }

    public function show($alunoId, $itemId)
    {
        $alunoItem = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
                                  ->where('item_loja_id_item_loja', $itemId)
                                  ->with(['aluno', 'itemLoja'])
                                  ->first();

        if (!$alunoItem) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        return response()->json($alunoItem);
    }

    public function destroy($alunoId, $itemId)
    {
        $alunoItem = AlunoItemLoja::where('aluno_id_usuario', $alunoId)
                                  ->where('item_loja_id_item_loja', $itemId)
                                  ->first();

        if (!$alunoItem) {
            return response()->json(['message' => 'Relacionamento não encontrado'], 404);
        }

        $alunoItem->delete();

        return response()->json(['message' => 'Item removido do aluno com sucesso!']);
    }
}