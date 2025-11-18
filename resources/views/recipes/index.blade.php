<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da Remenu</title>
  
 
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
</head>

<body>


<body>


    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-light border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-item-center fw-semibold" href="resources/views/home.blade.php">
            <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2">
            </a>
            <span class="titulo">Remenu</span>
            <!-- botão -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!--links menu-->
            <div class="collapse navbar-collapse justify-content-end" id="menuNav">
                <ul class ="navbar-nav mb-2 mb-">
                    <li class="nav-item">
                        <a class="nav-link active" href="home2">Início</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="receitas">Receitas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="#">Planejamento</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link active"  href="#">Favoritos</a>
                    </li>


                     <li class="nav-item">
                        <a class="nav-link active" href="geladeira">Minha Geladeira</a>
                    </li>
                </ul>
            </div>

            <a href="#" class="profile-link d-none d-lg-block" aria-label="Perfil"> <i class="bi bi-person-fill"></i>
            </a>
        </div>            
    </nav>

  <section class="receitas-banner"></section>

  <!-- TÍTULO + SUBTÍTULO -->
  <div class="receitas-title">
    <h1>Receitas</h1>
    <p>Descubra receitas deliciosas e saudáveis para todas as ocasiões</p>
  </div>



  
<form id="filter-form" method="GET" action="/receitas">

    <!-- BARRA PRINCIPAL -->
    <div class="search-bar">

        <!-- Buscar -->
        <div class="search-item">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Buscar receitas..."
                   value="{{ $search ?? '' }}">
        </div>

        <!-- Tipos de receita -->
        <button type="button" id="typesBtn" class="search-item btn-item">
            <i class="bi bi-funnel"></i>
            Filtrar por tipos de receita
        </button>

        <!-- Filtros avançados -->
        <button type="button" id="filtersBtn" class="search-item btn-item">
            <i class="bi bi-funnel"></i>
            Filtros
        </button>
    </div>

    <!-- DROPDOWN TIPOS -->
    <div id="typesBox" class="dropdown-box">
        <label>Tipos de receita</label>
        <select name="recipe_types[]" multiple size="6">
            <option value="" {{ empty($filters['recipe_types']) ? 'selected' : '' }}>Sem filtro</option>
            <option value="Main Dish">Prato Principal</option>
            <option value="Breakfast">Café da Manhã</option>
            <option value="Salad">Salada</option>
            <option value="Soup">Sopa</option>
            <option value="Dessert">Sobremesa</option>
            <option value="Beverage">Bebidas</option>
        </select>

        <button class="apply-filters">Aplicar</button>
    </div>

    <!-- DROPDOWN FILTROS AVANÇADOS -->
    <div id="filtersBox" class="dropdown-box">
        <label>Calorias:</label>
        <div class="two-inputs">
            <input type="number" name="calories_from" placeholder="Mín">
            <input type="number" name="calories_to" placeholder="Máx">
        </div>

        <label>Tempo de preparo (min):</label>
        <div class="two-inputs">
            <input type="number" name="prep_time_from" placeholder="Mín">
            <input type="number" name="prep_time_to" placeholder="Máx">
        </div>

        <button class="apply-filters">Aplicar filtros</button>
    </div>

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

  <footer>
    <footer class="main-footer">
    <div class="container py-4">

        <div class="row pt-3 pb-4">
            
            <div class="col-md-4 mb-4 mb-md-0 d-flex align-items-start">
                <div class="footer-info text-start">
                    <div class="footer-logo mb-3">
                        <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2 footer-logo-img">
                    </div>
                    <p class="mb-0 footer-text">Plataforma de receitas saudáveis<br>com foco em reduzir desperdício alimentar</p>
                </div>
            </div>

          <div class="col-md-5 mb-4 mb-md-0">
              <h5 class="footer-title text-center">Navegação</h5>
              
              <div class="footer-nav-grid mx-auto">
                  <ul class="list-unstyled footer-nav-col">
                      <li><a href="home2" class="footer-link"><i class="fas fa-home"></i> Home</a></li>
                      <li><a href="receitas" class="footer-link"><i class="fas fa-utensils"></i> Receitas</a></li>
                  </ul>
                  <ul class="list-unstyled footer-nav-col">
                      <li><a href="#" class="footer-link"><i class="fas fa-calendar-alt"></i> Planejamento</a></li>
                      <li><a href="#" class="footer-link"><i class="far fa-heart"></i> Favoritos</a></li>
                  </ul><ul class="list-unstyled footer-nav-col">
                      <li><a href="geladeira" class="footer-link"><i class="fas fa-snowflake"></i> Geladeira</a></li>
                  </ul>
              </div>
          </div>

            <div class="col-md-3 text-end">
                <h5 class="footer-title text-center text-md-end">Contato & Suporte</h5>
                <ul class="list-unstyled text-center text-md-end footer-text">
                    <li class="mb-1">contato@remenu.com.br</li>
                    <li>(11) 9999-9999</li>
                </ul>
            </div>
        </div>

        <hr class="footer-divider my-2">

        <div class="row footer-bottom py-3">
            <div class="col-12 text-center mb-2">
                <p class="mb-0 footer-text">© 2025 REMENU. Todos os direitos reservados.</p>
            </div>
            
            <div class="col-12 text-center">
                <div class="footer-links d-flex justify-content-center flex-wrap">
                    <a href="#" class="footer-link me-3 me-lg-4">Privacidade</a>
                    <a href="#" class="footer-link me-3 me-lg-4">Termos de Uso</a>
                    <a href="#" class="footer-link me-3 me-lg-4">FAQ</a>
                    <a href="#" class="footer-link">Suporte</a>
                </div>
            </div>
        </div>
    </div>
  </footer>

<script>
const typesBtn = document.getElementById("typesBtn");
const filtersBtn = document.getElementById("filtersBtn");
const typesBox = document.getElementById("typesBox");
const filtersBox = document.getElementById("filtersBox");

typesBtn.addEventListener("click", () => {
    typesBox.style.display = typesBox.style.display === "block" ? "none" : "block";
    filtersBox.style.display = "none";
});

filtersBtn.addEventListener("click", () => {
    filtersBox.style.display = filtersBox.style.display === "block" ? "none" : "block";
    typesBox.style.display = "none";
});
</script>




</body>
</html>
