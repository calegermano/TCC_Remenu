@foreach ($recipes as $recipe)
  <div class="recipe-card" data-id="{{ $recipe['recipe_id'] ?? '' }}">
    
    <!-- ADICIONANDO O BOTÃO DE FAVORITO AQUI TAMBÉM -->
    @auth
        @php
            // Verifica se o usuário já favoritou (usando a relação que criamos)
            $isFav = Auth::user()->favoritos->contains('recipe_id', $recipe['recipe_id']);
        @endphp
        <button class="btn-favorite {{ $isFav ? 'active' : '' }}" 
                data-id="{{ $recipe['recipe_id'] }}"
                data-name="{{ $recipe['recipe_name'] ?? 'Receita' }}"
                data-image="{{ $recipe['recipe_image'] ?? '' }}"
                data-calories="{{ $recipe['recipe_nutrition']['calories'] ?? '' }}"
                onclick="toggleFavorite(event, this)">
            <i class="bi {{ $isFav ? 'bi-heart-fill' : 'bi-heart' }}"></i>
        </button>
    @endauth
    <!-- FIM DO BOTÃO -->

    <img 
      src="{{ $recipe['recipe_image'] ?? asset('img/placeholder.png') }}" 
      alt="{{ $recipe['recipe_name'] ?? 'Receita sem nome' }}"
      onerror="this.onerror=null; this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
    >
    <h5 class="mt-2">{{ $recipe['recipe_name'] ?? 'Receita Desconhecida' }}</h5>
    <p>{{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>
  </div>
@endforeach