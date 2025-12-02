<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planejamento;
use Illuminate\Support\Facades\Auth;

class PlanejamentoController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->query('start'); // Ex: 2025-11-24
        $end = $request->query('end');     // Ex: 2025-11-30

        $plans = Planejamento::where('usuario_id', Auth::id())
                     ->whereBetween('date', [$start, $end])
                     ->get();

        return response()->json(['success' => true, 'data' => $plans]);
    }

    public function store(Request $request)
    {
        // Validação igual à Web
        $data = $request->validate([
            'recipe_id' => 'required',
            'date' => 'required|date',
            'meal_type' => 'required',
            'recipe_name' => 'required',
            'recipe_image' => 'nullable',
            'calories' => 'nullable',
            'protein' => 'nullable',
            'carbs' => 'nullable',
        ]);

        $data['usuario_id'] = Auth::id();
        $data['calories'] = floatval($data['calories'] ?? 0);

        // Remove anterior no mesmo slot
        Planejamento::where('usuario_id', Auth::id())
            ->where('date', $data['date'])
            ->where('meal_type', $data['meal_type'])
            ->delete();

        $plan = Planejamento::create($data);

        return response()->json(['success' => true, 'data' => $plan]);
    }

    public function destroy($id)
    {
        $plan = Planejamento::where('usuario_id', Auth::id())->where('id', $id)->first();
        if ($plan) {
            $plan->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Não encontrado'], 404);
    }
}