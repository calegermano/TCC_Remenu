<div class="recipe-card" data-id="{{ $recipe['recipe_id'] }}">
    <img 
        src="{{ $recipe['recipe_image'] ?? asset('img/placeholder.png') }}" 
        alt="{{ $recipe['recipe_name'] ?? 'Receita sem nome' }}"
        onerror="this.onerror=null; this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
    >
    <h5 class="mt-2">{{ $recipe['recipe_name'] ?? 'Receita Desconhecida' }}</h5>
    <p>{{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>
    
    <!-- BOTÕES DE AÇÃO - SERÃO INTERCEPTADOS PELO MIDDLEWARE -->
    <div class="recipe-actions mt-2">
        <!-- Favoritar -->
        <form action="{{ route('recipes.favorite', $recipe['recipe_id']) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Favoritar">
                <i class="bi bi-heart"></i>
            </button>
        </form>
        
        <!-- Adicionar ao Planejamento -->
        <form action="{{ route('recipes.plan', $recipe['recipe_id']) }}" method="POST" class="d-inline ms-1">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary" title="Adicionar ao planejamento">
                <i class="bi bi-calendar-plus"></i>
            </button>
        </form>
        
        <!-- Adicionar Ingredientes à Lista -->
        <form action="{{ route('recipes.add_ingredients', $recipe['recipe_id']) }}" method="POST" class="d-inline ms-1">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-success" title="Adicionar ingredientes à lista">
                <i class="bi bi-cart-plus"></i>
            </button>
        </form>
    </div>
</div>