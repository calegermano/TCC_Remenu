<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Geladeira;
use App\Models\Ingredientes;
use Illuminate\Support\Facades\Auth;

class GeladeiraController extends Controller
{
    // 1. LISTAR ITENS (Agrupados por Categoria)
    public function index()
    {
        $usuarioId = Auth::id();

        // Carrega Geladeira -> Ingrediente -> Categoria
        $itens = Geladeira::with('ingrediente.categoria')
            ->where('usuario_id', $usuarioId)
            ->get();

        // Agrupa os dados para o SectionList do Mobile
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
            })->values(); // values() garante que vire array JSON limpo
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

    // 3. ADICIONAR ITEM
    public function store(Request $request)
    {
        $request->validate([
            'ingrediente' => 'required|string',
            'quantidade' => 'required|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $usuarioId = Auth::id();

        // Busca o ingrediente no banco de dados
        $ingredienteDB = Ingredientes::where('nome', $request->ingrediente)->first();

        if (!$ingredienteDB) {
            return response()->json([
                'erro' => 'Ingrediente não encontrado. Selecione da lista.'
            ], 404);
        }

        // Verifica se o usuário já tem esse item na geladeira
        $item = Geladeira::where('usuario_id', $usuarioId)
            ->where('ingrediente_id', $ingredienteDB->id)
            ->first();

        if ($item) {
            // Se já tem, soma a quantidade
            $item->quantidade += $request->quantidade;
            if ($request->validade) {
                $item->validade = $request->validade;
            }
            $item->save();
            return response()->json(['mensagem' => 'Quantidade atualizada', 'item' => $item]);
        }

        // Se não tem, cria novo
        $novo = Geladeira::create([
            'usuario_id' => $usuarioId,
            'ingrediente_id' => $ingredienteDB->id,
            'quantidade' => $request->quantidade,
            'validade' => $request->validade,
        ]);

        return response()->json($novo, 201);
    }

    // 4. ATUALIZAR (Editar quantidade/validade)
    public function update(Request $request, $id)
    {
        $item = Geladeira::where('usuario_id', Auth::id())->where('id', $id)->first();

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

    // 5. REMOVER
    public function destroy($id)
    {
        $item = Geladeira::where('usuario_id', Auth::id())->where('id', $id)->first();

        if ($item) {
            $item->delete();
            return response()->json(['status' => 'deleted']);
        }

        return response()->json(['erro' => 'Item não encontrado'], 404);
    }
}