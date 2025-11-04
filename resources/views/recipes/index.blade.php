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
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4 text-center">Receitas da FatSecret</h1>

    <form method="GET" action="{{ route('recipes.index') }}" class="d-flex justify-content-center mb-4">
      <input type="text" name="search" value="{{ $search }}" placeholder="Buscar receita..." class="form-control w-50 me-2">
      <button type="submit" class="btn btn-success">Buscar</button>
    </form>

    <div class="row">
      @forelse($recipes as $recipe)
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <img src="{{ $recipe['recipe_image'] ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $recipe['recipe_name'] }}">
            <div class="card-body">
              <h5 class="card-title">{{ $recipe['recipe_name'] }}</h5>
              <p class="card-text">{{ $recipe['recipe_description'] ?? 'Sem descrição disponível.' }}</p>
              <p><strong>Calorias:</strong> {{ $recipe['recipe_nutrition']['calories'] ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">Nenhuma receita encontrada.</p>
      @endforelse
    </div>
  </div>
</body>
</html>
