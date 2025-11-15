<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da Remenu</title>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h1 class="mb-4 text-center">Receitas da FatSecret</h1>

    <form id="filter-form" method="GET" action="/receitas" class="filters">
      <input type="text" name="search" placeholder="Buscar receita..." value="{{ $search ?? '' }}">

      <label>Calorias:</label>
      <input type="number" name="calories_from" placeholder="Mín" value="{{ $filters['calories_from'] ?? '' }}">
      <input type="number" name="calories_to" placeholder="Máx" value="{{ $filters['calories_to'] ?? '' }}">

      <label>Tempo de preparo (min):</label>
      <input type="number" name="prep_time_from" placeholder="Mín" value="{{ $filters['prep_time_from'] ?? '' }}">
      <input type="number" name="prep_time_to" placeholder="Máx" value="{{ $filters['prep_time_to'] ?? '' }}">

      <details>
        <summary>Filtrar por tipo de receita</summary>
        <select name="recipe_types[]" multiple size="6" style="width: 100%; max-width: 300px;">
          <option value="" {{ empty($filters['recipe_types']) ? 'selected' : '' }}>Sem filtro</option>
          <option value="Main Dish" {{ in_array('Main Dish', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Prato Principal</option>
          <option value="Breakfast" {{ in_array('Breakfast', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Café da Manhã</option>
          <option value="Salad" {{ in_array('Salad', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Salada</option>
          <option value="Soup" {{ in_array('Soup', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sopa</option>
          <option value="Dessert" {{ in_array('Dessert', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sobremesa</option>
          <option value="Beverage" {{ in_array('Beverage', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Bebidas</option>
        </select>
      </details>

      <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div id="recipes-container" class="recipes-grid">
      @forelse ($recipes as $recipe)
        <div class="recipe-card" data-id="{{ $recipe['recipe_id'] }}">
          <img 
            src="{{ $recipe['recipe_image'] ?? asset('img/placeholder.png') }}" 
            alt="{{ $recipe['recipe_name'] ?? 'Receita sem nome' }}"
            onerror="this.onerror=null; this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
          >
          <h5 class="mt-2">{{ $recipe['recipe_name'] ?? 'Receita Desconhecida' }}</h5>
          <p>{{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>
        </div>
      @empty
        <p>Nenhuma receita encontrada.</p>
      @endforelse

    </div>

    <div id="loading" style="display:none; text-align:center; margin:20px;">
      <div class="spinner-border text-primary" role="status"></div>
      <p>Carregando mais receitas...</p>
    </div>

  </div>

    <div id="recipeModal" class="modal-overlay" style="display: none;">
      <div class="modal-card">
          <button class="close-modal">X</button>
          <img id="modalImage" src="" alt="">
          <h2 id="modalName"></h2>
          <p><strong>Calorias:</strong> <span id="modalCalories"></span></p>
          <p><strong>Tempo de preparo:</strong> <span id="modalPrep"></span></p>

          <h4>Ingredientes</h4>
          <ul id="modalIngredients"></ul>

          <h4>Modo de preparo</h4>
          <p id="modalDirections"></p>

          <h4>Informação Nutricional</h4>
          <p id="modalNutrition"></p>
      </div>
    </div>


  <script>
  document.addEventListener('DOMContentLoaded', function () {
      let page = 0;
      let loading = false;
      const recipeContainer = document.getElementById('recipes-container');
      const searchForm = document.getElementById('filter-form');
      const loadingIndicator = document.getElementById('loading');

      async function loadMoreRecipes() {
          if (loading) return;
          loading = true;
          page++;

          loadingIndicator.style.display = 'block'; // mostra o spinner

          const formData = new FormData(searchForm);
          formData.append('page', page);
          const queryString = new URLSearchParams(formData).toString();

          try {
              const response = await fetch(`/receitas?${queryString}`, {
                  headers: { 'X-Requested-With': 'XMLHttpRequest' }
              });

              if (!response.ok) throw new Error('Erro ao carregar receitas');
              const html = await response.text();

              // Cria elemento temporário para pegar os novos cards
              const tempDiv = document.createElement('div');
              tempDiv.innerHTML = html;

              const newRecipes = tempDiv.querySelectorAll('.recipe-card');
              if (newRecipes.length === 0) {
                  window.removeEventListener('scroll', handleScroll);
                  loadingIndicator.innerHTML = '<p>Não há mais receitas.</p>';
                  return;
              }

              newRecipes.forEach(card => recipeContainer.appendChild(card));

          } catch (error) {
              console.error(error);
          } finally {
              loadingIndicator.style.display = 'none';
              loading = false;
          }
      }

      function handleScroll() {
          const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 300;
          if (nearBottom) loadMoreRecipes();
      }

      window.addEventListener('scroll', handleScroll);
  });
  </script>

  <script>
  // Evento delegando clique para qualquer .recipe-card, inclusive os que carregam depois
  document.addEventListener('click', function(e) {
      const card = e.target.closest('.recipe-card');
      if (!card) return;

      const id = card.dataset.id;

      fetch(`/receita/${id}`)
          .then(res => res.json())
          .then(data => {
              document.getElementById('modalName').textContent = data.recipe_name;
              document.getElementById('modalImage').src = data.recipe_image || '/img/placeholder.png';
              document.getElementById('modalCalories').textContent = data.recipe_nutrition?.calories ?? 'N/A';
              document.getElementById('modalPrep').textContent =
                  (data.preparation_time_min ?? 0) + (data.cooking_time_min ?? 0) + " min";

              // Ingredientes
              let ingList = document.getElementById('modalIngredients');
              ingList.innerHTML = '';
              if (data.ingredients?.ingredient) {
                  data.ingredients.ingredient.forEach(i => {
                      let li = document.createElement('li');
                      li.textContent = i.ingredient_description;
                      ingList.appendChild(li);
                  });
              }

              // Modo de preparo
              document.getElementById('modalDirections').textContent =
                  data.directions?.direction?.map(d => d.direction_description).join(" ") ?? "—";

              // Nutrição extra
              let nutrition = data.recipe_nutrition;
              if (nutrition) {
                  document.getElementById('modalNutrition').textContent =
                      `Proteínas: ${nutrition.protein ?? 'N/A'}g — Carboidratos: ${nutrition.carbohydrate ?? 'N/A'}g — Gorduras: ${nutrition.fat ?? 'N/A'}g`;
              } else {
                  document.getElementById('modalNutrition').textContent = "N/A";
              }

              document.getElementById('recipeModal').style.display = 'flex';
          });
  });

  // Fechar modal
  document.querySelector('.close-modal').addEventListener('click', () => {
      document.getElementById('recipeModal').style.display = 'none';
  });
  </script>




</body>
</html>
