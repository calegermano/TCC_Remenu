<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da FatSecret</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f9f9f9; }
    .card img { height: 200px; object-fit: cover; }
    .container { padding-top: 40px; }

    .filters {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }

    .filters input, .filters select, .filters button {
      margin: 5px;
    }

    .recipes-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .recipe-card {
      background: #fff;
      border-radius: 10px;
      padding: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }

    .recipe-card img {
      border-radius: 8px;
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .pagination {
      display: flex;
      justify-content: center;
      gap: 5px;
      margin-top: 25px;
    }

    .pagination a {
      padding: 8px 12px;
      background: #eee;
      border-radius: 5px;
      text-decoration: none;
      color: #333;
    }

    .pagination a.active {
      background: #007bff;
      color: white;
    }

    /* Dropdown bonito */
    details {
      margin: 10px 0;
    }
    summary {
      cursor: pointer;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4 text-center">Receitas da FatSecret</h1>

    <form method="GET" action="/receitas" class="filters">
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
          <option value="Appetizer" {{ in_array('Appetizer', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Aperitivo</option>
          <option value="Breakfast" {{ in_array('Breakfast', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Café da Manhã</option>
          <option value="Salad" {{ in_array('Salad', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Salada</option>
          <option value="Soup" {{ in_array('Soup', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sopa</option>
          <option value="Dessert" {{ in_array('Dessert', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sobremesa</option>
          <option value="Drink" {{ in_array('Drink', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Bebidas</option>
          <option value="Snack" {{ in_array('Snack', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Lanche</option>
          <option value="Side Dish" {{ in_array('Side Dish', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Acompanhamento</option>
        </select>
      </details>

      <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div class="recipes-grid">
      @forelse ($recipes as $recipe)
        <div class="recipe-card">
          <img src="{{ $recipe['recipe_image'] ?? '/img/placeholder.png' }}" alt="{{ $recipe['recipe_name'] }}">
          <h5 class="mt-2">{{ $recipe['recipe_name'] }}</h5>
          <p>{{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>
        </div>
      @empty
        <p>Nenhuma receita encontrada.</p>
      @endforelse
    </div>

    @if ($totalPages > 1)
      <div class="pagination">
        @for ($i = 0; $i < $totalPages; $i++)
          <a href="?{{ http_build_query(array_merge(request()->all(), ['page' => $i])) }}"
            class="{{ $i == $page ? 'active' : '' }}">
            {{ $i + 1 }}
          </a>
        @endfor
      </div>
    @endif

  </div>
</body>
</html>
