<?php

namespace App\Http\Controllers;

use App\Models\Geladeira;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeladeiraController extends Controller
{
    // LISTAR INGREDIENTES DO USUÁRIO AGRUPADOS POR CATEGORIA
    public function index()
    {
        $usuarioId = Auth::id();

        $itens = Geladeira::with('ingrediente.categoria')
            ->where('usuario_id', $usuarioId)
            ->get();

        $organizado = $itens->groupBy(function ($item) {
            return $item->ingrediente->categoria->nome;
        })->map(function ($grupo) {
            return $grupo->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ingrediente' => $item->ingrediente->nome,
                    'categoria' => $item->ingrediente->categoria->nome,
                    'quantidade' => $item->quantidade,
                    'validade' => $item->validade,
                ];
            });
        });

        return response()->json($organizado);
    }

    // AUTOCOMPLETE PARA PESQUISAS DE INGREDIENTES
    public function search(Request $request)
    {
        $termo = $request->input('q');

        $resultados = Ingrediente::where('nome', 'like', "%{$termo}%")
            ->limit(10)
            ->get();

        return response()->json($resultados);
    }

    // ADICIONAR INGREDIENTE À GELADEIRA
    // CASO JÁ EXISTA -> SOMA QUANTIDADE
    public function store(Request $request)
    {
        $request->validate([
            'ingrediente' => 'required|string',
            'quantidade' => 'required|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $usuarioId = Auth::id();

        $ingrediente = Ingrediente::where('nome', $request->ingrediente)->first();

        if (!$ingrediente) {
            return response()->json([
                'erro' => 'Ingrediente não encontrado no banco de dados.'
            ], 404);
        }

        $item = Geladeira::where('usuario_id', $usuarioId)
            ->where('ingrediente_id', $ingrediente->id)
            ->first();

        if ($item) {
            $item->quantidade += $request->quantidade;

            if ($request->validade) {
                $item->validade = $request->validade;
            }

            $item->save();

            return response()->json([
                'mensagem' => 'Quantidade atualizada.',
                'item' => $item
            ]);
        }

        $novo = Geladeira::create([
            'usuario_id' => $usuarioId,
            'ingrediente_id' => $ingrediente->id,
            'quantidade' => $request->quantidade,
            'validade' => $request->validade,
        ]);

        return response()->json($novo, 201);
    }

    // ATUALIZAR QUANTIDADE E VALIDADE
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'nullable|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $item = Geladeira::findOrFail($id);

        if ($request->ingrediente_id || $request->ingrediente) {
            return response()->json([
                'erro' => 'O ingrediente não pode ser alterado, apenas quantidade e validade.'
            ], 400);
        }

        if ($request->quantidade) {
            $item->quantidade = $request->quantidade;
        }

        if ($request->validade) {
            $item->validade = $request->validade;
        }

        $item->save();

        return response()->json($item);
    }

    // REMOVER ITEM DA GELADEIRA
    public function destroy($id)
    {
        $item = Geladeira::findOrFail($id);
        $item->delete();

        return response()->json(['mensagem' => 'Ingrediente removido.']);
    }
}
