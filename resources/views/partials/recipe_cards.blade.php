@foreach ($recipes as $recipe)
  <div class="recipe-card" data-id="{{ $recipe['recipe_id'] ?? '' }}">
    <img 
      src="{{ $recipe['recipe_image'] ?? asset('img/placeholder.png') }}" 
      alt="{{ $recipe['recipe_name'] ?? 'Receita sem nome' }}"
      onerror="this.onerror=null; this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
    >
    <h5 class="mt-2">{{ $recipe['recipe_name'] ?? 'Receita Desconhecida' }}</h5>
    <p>{{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>
  </div>
@endforeach
