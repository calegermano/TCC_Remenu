<?php

namespace App\Http\Controllers;

use App\Services\FatSecretService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $fatSecret;

    public function __construct(FatSecretService $fatSecret)
    {
        $this->fatSecret = $fatSecret;
    }

    public function index(Request $request)
    {
        $search = $request->get('search', 'frango');
        $recipes = $this->fatSecret->getRecipes($search);
        return view('recipes.index', compact('recipes', 'search'));
    }
}
