<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Geladeira;
use App\Models\Ingredientes;

class GeladeiraApiController extends Controller
{
    
    public function index(Request $request)
    {
        
        $usuarioId = $request->user()->id;

        $itens = Geladeira::with('ingrediente.categoria')
            ->where('usuario_id', $usuarioId)
            ->get();

        $organizado = $itens->groupBy(function ($item) {
            if ($item->ingrediente && $item->ingrediente->categoria) {
                return $item->ingrediente->categoria->nome;
            }
            return 'Outros';
        })->map(function ($grupo) {
            return $grupo->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ingrediente' => $item->ingrediente->nome ?? 'Item desconhecido',
                    'quantidade' => $item->quantidade,
                    'validade' => $item->validade,
                ];
            })->values();
        });

        return response()->json($organizado);
    }

    // 2. BUSCA DE INGREDIENTES (Autocomplete)
    public function search(Request $request)
    {
        $query = $request->query('query', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Ingredientes::where('nome', 'LIKE', "%{$query}%")
            ->orderBy('nome')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // 3. ADICIONAR ITEM (Corrigido ✅)
    public function store(Request $request)
    {
        $request->validate([
            'ingrediente' => 'required|string',
            'quantidade' => 'required|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $usuarioId = $request->user()->id;

        $ingredienteDB = Ingredientes::where('nome', $request->ingrediente)->first();

        if (!$ingredienteDB) {
            return response()->json([
                'erro' => 'Ingrediente não encontrado. Selecione da lista.'
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
            return response()->json(['mensagem' => 'Quantidade atualizada', 'item' => $item]);
        }

        $novo = Geladeira::create([
            'usuario_id' => $usuarioId,
            'ingrediente_id' => $ingredienteDB->id,
            'quantidade' => $request->quantidade,
            'validade' => $request->validade,
        ]);

        return response()->json($novo, 201);
    }

    // 4. ATUALIZAR (Correção Aplicada Aqui ⚠️)
    public function update(Request $request, $id)
    {
        // Mudei de Auth::id() para $request->user()->id
        $usuarioId = $request->user()->id;
        
        $item = Geladeira::where('usuario_id', $usuarioId)->where('id', $id)->first();

        if (!$item) {
            return response()->json(['erro' => 'Item não encontrado'], 404);
        }

        if ($request->has('quantidade')) {
            $item->quantidade = $request->quantidade;
        }
        if ($request->has('validade')) {
            $item->validade = $request->validade;
        }

        $item->save();

        return response()->json($item);
    }

    // 5. REMOVER (Correção Aplicada Aqui ⚠️)
    // Adicionei Request $request nos parâmetros
    public function destroy(Request $request, $id)
    {
        // Mudei de Auth::id() para $request->user()->id
        $usuarioId = $request->user()->id;

        $item = Geladeira::where('usuario_id', $usuarioId)->where('id', $id)->first();

        if ($item) {
            $item->delete();
            return response()->json(['status' => 'deleted']);
        }

        return response()->json(['erro' => 'Item não encontrado'], 404);
    }
}