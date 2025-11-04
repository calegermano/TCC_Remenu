<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredienteController extends Controller
{

    public function IngredientesLista()
    {
        //lista de ingredientes
        $ingredientes = Ingredientes::all();
        $contadorIngredientes = $ingredientes->count();
        if ($contadorIngredientes > 0) {
            return response()->json ([
                'success' => true,
                'message' => 'Ingredientes encontrados com sucesso:',
                'data' => $ingredientes,
                'total' => $contadorIngredientes
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum ingrediente encontrado.'
            ], 400);
        }
    }

    public function CategoriasLista()
    {
        //lista de categorias
        $categorias = CategoriaIngredientes::all();
        $contadorCategorias = $categorias->count();
        if ($contadorCategorias > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Categorias encontrados com sucesso:',
                'data' => $categorias,
                'total' => $contadorCategorias
            ], 200);
        } else {
            return response ()->json([
                'success' => false,
                'message' => 'Nenhuma categoria encontrada.',
            ], 400);
        }
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
