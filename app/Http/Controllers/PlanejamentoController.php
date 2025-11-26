<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planejamento;
use Illuminate\Support\Facades\Auth;

class PlanejamentoController extends Controller
{
    public function index()
    {
        $favoritos = Auth::user()->favoritos; 
        return view('planejamento.index', compact('favoritos'));
    }

    // Busca os planos (AJAX)
    public function getPlans(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $plans = Planejamento::where('usuario_id', Auth::id())
                     ->whereBetween('date', [$start, $end])
                     ->get();

        return response()->json($plans);
    }

    // Salvar
    public function store(Request $request)
    {
        $data = $request->validate([
            'recipe_id' => 'required',
            'date' => 'required|date',
            'meal_type' => 'required',
            'recipe_name' => 'required',
            'recipe_image' => 'nullable',
            'calories' => 'numeric',
            'protein' => 'numeric',
            'carbs' => 'numeric',
        ]);

        $data['usuario_id'] = Auth::id();

        // Remove anterior se existir (substituição)
        Planejamento::where('usuario_id', Auth::id())
            ->where('date', $data['date'])
            ->where('meal_type', $data['meal_type'])
            ->delete();

        $plan = Planejamento::create($data);

        return response()->json(['status' => 'success', 'plan' => $plan]);
    }

    // Remover
    public function destroy($id)
    {
        $plan = Planejamento::where('usuario_id', Auth::id())->where('id', $id)->first();
        if ($plan) {
            $plan->delete();
            return response()->json(['status' => 'deleted']);
        }
        return response()->json(['status' => 'error'], 404);
    }
}