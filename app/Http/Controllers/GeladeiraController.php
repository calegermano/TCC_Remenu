<?php

namespace App\Http\Controllers;

use App\Models\Geladeira;
use App\Models\Ingredientes; // <--- AGORA NO PLURAL, IGUAL SEU MODEL
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeladeiraController extends Controller
{
    
    // LISTAR INGREDIENTES DO USUÁRIO AGRUPADOS POR CATEGORIA
    public function index()
    {
        $usuarioId = Auth::id();

        // Carrega: Geladeira -> func ingrediente() -> func categoria()
        // No seu model Geladeira a função chama 'ingrediente' (singular), isso tá certo.
        // No model Ingredientes a função chama 'categoria' (singular), isso tá certo.
        $itens = Geladeira::with('ingrediente.categoria')
            ->where('usuario_id', $usuarioId)
            ->get();

        $organizado = $itens->groupBy(function ($item) {
            // Verifica se o ingrediente e a categoria existem para não dar erro
            if ($item->ingrediente && $item->ingrediente->categoria) {
                return $item->ingrediente->categoria->nome;
            }
            return 'Outros';
        })->map(function ($grupo) {
            return $grupo->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ingrediente' => $item->ingrediente->nome ?? 'Item desconhecido',
                    'categoria' => $item->ingrediente->categoria->nome ?? 'Outros',
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
        $query = $request->query('query', '');

        // <--- MUDANÇA AQUI: Usa 'Ingredientes' (Plural)
        return Ingredientes::where('nome', 'LIKE', "%$query%")
            ->orderBy('nome')
            ->limit(10)
            ->get();
    }

    // ADICIONAR INGREDIENTE À GELADEIRA
    public function store(Request $request)
    {
        $request->validate([
            'ingrediente' => 'required|string',
            'quantidade' => 'required|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $usuarioId = Auth::id();

        // <--- MUDANÇA AQUI: Usa 'Ingredientes' (Plural)
        $ingredienteDB = Ingredientes::where('nome', $request->ingrediente)->first();

        if (!$ingredienteDB) {
            // Retorna 404 para o front mostrar o alerta
            return response()->json([
                'erro' => 'Ingrediente não encontrado no sistema. Tente usar o autocomplete.'
            ], 404);
        }

        $item = Geladeira::where('usuario_id', $usuarioId)
            ->where('ingrediente_id', $ingredienteDB->id)
            ->first();

        if ($item) {
            $item->quantidade += $request->quantidade;
            if ($request->validade) {
                $item->validade = $request->validade;
            }
            $item->save();
            return response()->json(['mensagem' => 'Atualizado', 'item' => $item]);
        }

        $novo = Geladeira::create([
            'usuario_id' => $usuarioId,
            'ingrediente_id' => $ingredienteDB->id,
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