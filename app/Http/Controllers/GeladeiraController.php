<?php

namespace App\Http\Controllers;

use App\Models\Geladeira;
use Illuminate\Http\Request;

class GeladeiraController extends Controller
{

    public function index()
    {
        $usuario = auth()->user();

        $itens = Geladeira::where('$usario_id', $usario->id)
            ->with(['ingrediente.categoria'])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ingredientes' => $item->ingrediente->nome,
                    'categoria' => $item->ingrediente->categoria->nome ?? null,
                    'quantidade' => $item->quantidade,
                    'validade' => $item->validade,
                ];
            });

        return response()->json([
            'usuario' => $usuario->nome,
            'geladeira' => $itens,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingrediente_nome' => 'required| string',
            'quantidade' => 'nullable|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        $usaurio = auth()->user();

        $ingrediente = Ingrediente::where('nome', $request->ingrediente_nome)->first();

        if (!$ingrediente) {
            return response()->json([
                'error' => 'Ingrediente não encontrado',
            ], 404);
        }

        $existe = Geladeira::where('usuario_id', $usuario->id)
            ->where('ingredientes_id', $ingrediente->id)
            ->first();

        if($existe) {
            return response()->json([
                'error' => 'Ingrediente ja existe na sua geladeira',
            ], 409);
        }

        $item = Geladeira::create([
            'usuario_id' => $usuario->id,
            'ingrediente_id' => $ingrediente->id,
            'quantidade' => $request->quantidade ?? 1,
            'validade' => $request->validade,
        ]);

        return response()->json([
            'message' => 'Ingrediente adicionado com sucesso',
            'item' => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $item = Geladeira::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->first();
        
        if (!$item) {
            return response()->json([
                'error' => 'Item não enconrado na sua geladeira'
            ], 404);
        }

        $request->validate([
            'ingrediente_nome' => 'nullable|string',
            'quantidade' => 'nullable|integer|min:1',
            'validade' => 'nullable|date',
        ]);

        if ($request->filled('ingrediente_nome')) {
            $novoIngrediente = Ingrediente::where('nome', $request->ingrediente_nome)->first();
            if (!$novoIngrediente) {
                return response()->json([
                    'error' => 'Novo ingrediente não foi encontrado.'
                ], 404);
            }
            $item->ingrediente_id = $novoIngrediente->id;
        }

        if ($request->filled('quantidade')) {
            $item->quantidade = $request->quantidade;
        }
        if ($request->filled('validade')) {
            $item->validade = $request->validade;
        }

        $item->save();

        return response()->json([
            'message' => 'Item atualizado com sucesso',
            'item' => $item,
        ], 200);
    }

    public function destroy($id)
    {
        $usuario = auth()->user();

        $item = Geladeira::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->first();

        if (!$item){
            return response()->json([
                'error' => 'Ingrediente não encontrado na geladeira'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'Ingrediente removido com sucesso',
        ], 200);
    }
}
