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
                        <a class="nav-link active" href="planejamento">Planejamento</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link active"  href="favoritos">Favoritos</a>
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
            <option value="Main Dish" {{ in_array('Main Dish', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Prato Principal</option>
            <option value="Breakfast" {{ in_array('Breakfast', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Café da Manhã</option>
            <option value="Salad" {{ in_array('Salad', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Salada</option>
            <option value="Soup" {{ in_array('Soup', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sopa</option>
            <option value="Dessert" {{ in_array('Dessert', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Sobremesa</option>
            <option value="Beverage" {{ in_array('Beverage', $filters['recipe_types'] ?? []) ? 'selected' : '' }}>Bebidas</option>
        </select>

        <button type="submit" class="apply-filters">Aplicar</button>

    </div>

    <!-- DROPDOWN FILTROS AVANÇADOS -->
    <div id="filtersBox" class="dropdown-box">
        <label>Calorias:</label>
        <div class="two-inputs">
            <input type="number" name="calories_from" placeholder="Mín" value="{{ $filters['calories_from'] ?? '' }}">
            <input type="number" name="calories_to" placeholder="Máx" value="{{ $filters['calories_to'] ?? '' }}">
        </div>

        <label>Tempo de preparo (min):</label>
        <div class="two-inputs">
            <input type="number" name="prep_time_from" placeholder="Mín" value="{{ $filters['prep_time_from'] ?? '' }}">
            <input type="number" name="prep_time_to" placeholder="Máx" value="{{ $filters['prep_time_to'] ?? '' }}">
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
        let page = 1;
        let loading = false;
        const recipeContainer = document.getElementById('recipes-container');
        const searchForm = document.getElementById('filter-form');
        const loadingIndicator = document.getElementById('loading');

        async function loadMoreRecipes() {
            if (loading) return;
            loading = true;
            page++;

            loadingIndicator.style.display = 'block';

            const formData = new FormData();

            // copiar TODOS os valores do formulário manualmente
            document.querySelectorAll('#filter-form [name]').forEach(el => {
                if (el.type === 'select-multiple') {
                    [...el.options].forEach(opt => {
                        if (opt.selected && opt.value !== "") {
                            formData.append(el.name, opt.value);
                        }
                    });
                } else if (el.value !== "") {
                    formData.append(el.name, el.value);
                }
            });

            formData.append('page', page);
            const queryString = new URLSearchParams(formData).toString();

            try {
                const response = await fetch(`/receitas?${queryString}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) throw new Error('Erro ao carregar receitas');
                const html = await response.text();

                if (!html.trim()) {
                    window.removeEventListener('scroll', handleScroll);
                    loadingIndicator.innerHTML = '<p>Não há mais receitas.</p>';
                    return;
                }

                recipeContainer.insertAdjacentHTML('beforeend', html);

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newCards = doc.querySelectorAll('.recipe-card');

                if (newCards.length === 0) {
                    window.removeEventListener('scroll', handleScroll);
                    loadingIndicator.innerHTML = '<p>Não há mais receitas.</p>';
                }

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
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Lógica para ABRIR o Modal ao clicar no Card
        document.addEventListener('click', function(e) {
            const card = e.target.closest('.recipe-card');
            if (!card) return;

            const id = card.dataset.id;
            if (!id) return;

            const modal = document.getElementById('recipeModal');
            
            // Exibir modal com estado de carregamento
            modal.style.display = 'flex';
            document.getElementById('modalName').textContent = 'Carregando...';
            document.getElementById('modalImage').src = '{{ asset("img/placeholder.png") }}';
            
            // Limpar campos anteriores para não mostrar dados velhos
            document.getElementById('modalCalories').textContent = '';
            document.getElementById('modalPrep').textContent = '';
            document.getElementById('modalIngredients').innerHTML = '';
            document.getElementById('modalDirections').innerHTML = '';
            document.getElementById('modalNutrition').textContent = '';

            // ... (código anterior de abrir o modal) ...

            console.log("Buscando ID:", id); // <--- DEBUG 1

            fetch(`/receitas/${encodeURIComponent(id)}`)
                .then(res => {
                    if (!res.ok) throw new Error('Erro na resposta do servidor');
                    return res.json();
                })
                .then(data => {
                    const r = data.recipe;

                    if (!r || data.error) {
                        document.getElementById('modalName').textContent = 'Erro ao carregar';
                        return;
                    }

                    // --- AJUSTE PARA PEGAR NUTRIÇÃO CORRETAMENTE ---
                    let nutrition = {};
                    
                    // A FatSecret coloca a nutrição dentro de serving_sizes -> serving
                    if (r.serving_sizes && r.serving_sizes.serving) {
                        const s = r.serving_sizes.serving;
                        // Se houver múltiplos tamanhos de porção, pega o primeiro (array), senão pega o objeto direto
                        nutrition = Array.isArray(s) ? s[0] : s;
                    }

                    // 1. NOME
                    document.getElementById('modalName').textContent = r.recipe_name ?? '—';

                    // 2. IMAGEM
                    let imgSrc = '{{ asset("assets/img/semImagem.jpeg") }}';
                    if (r.recipe_image) {
                        imgSrc = r.recipe_image;
                    } else if (r.recipe_images && r.recipe_images.recipe_image) {
                        let imgs = r.recipe_images.recipe_image;
                        imgSrc = Array.isArray(imgs) ? imgs[0] : imgs;
                    }
                    document.getElementById('modalImage').src = imgSrc;

                    // 3. CALORIAS (Corrigido)
                    // Agora pegamos da variável 'nutrition' que definimos acima
                    document.getElementById('modalCalories').textContent = nutrition.calories ?? 'N/A';

                    // 4. TEMPO
                    const prep = parseInt(r.preparation_time_min ?? 0);
                    const cook = parseInt(r.cooking_time_min ?? 0);
                    const total = prep + cook;
                    document.getElementById('modalPrep').textContent = total > 0 ? total + ' min' : 'N/A';

                    // 5. INGREDIENTES
                    const ingList = document.getElementById('modalIngredients');
                    ingList.innerHTML = '';

                    let ingredientsRaw = [];
                    if (r.ingredients && r.ingredients.ingredient) {
                        ingredientsRaw = r.ingredients.ingredient;
                    }

                    if (!Array.isArray(ingredientsRaw) && ingredientsRaw) {
                        ingredientsRaw = [ingredientsRaw];
                    }

                    if (ingredientsRaw.length > 0) {
                        ingredientsRaw.forEach(item => {
                            const li = document.createElement('li');
                            const text = item.ingredient_description ?? item.food_name ?? item;
                            const measurement = item.measurement_description ?? '';
                            li.textContent = measurement ? `${measurement} ${text}` : text;
                            ingList.appendChild(li);
                        });
                    } else {
                        ingList.innerHTML = '<li>Sem ingredientes listados.</li>';
                    }

                    // 6. MODO DE PREPARO
                    const directionsContainer = document.getElementById('modalDirections');
                    directionsContainer.innerHTML = ''; 

                    let directionsRaw = [];
                    if (r.directions && r.directions.direction) {
                        directionsRaw = r.directions.direction;
                    }

                    if (!Array.isArray(directionsRaw) && directionsRaw) {
                        directionsRaw = [directionsRaw];
                    }

                    if (directionsRaw.length > 0) {
                        directionsRaw.sort((a, b) => (a.direction_number - b.direction_number));
                        directionsRaw.forEach(step => {
                            const p = document.createElement('p');
                            p.style.marginBottom = "10px";
                            p.textContent = `${step.direction_number ? step.direction_number + '.' : '•'} ${step.direction_description}`;
                            directionsContainer.appendChild(p);
                        });
                    } else {
                        directionsContainer.textContent = r.recipe_description ?? 'Modo de preparo não disponível.';
                    }

                    // 7. NUTRIÇÃO (Corrigido)
                    // Usando a variável 'nutrition' extraída do serving_sizes
                    document.getElementById('modalNutrition').textContent =
                        `Proteínas: ${nutrition.protein ?? '0'}g — Carboidratos: ${nutrition.carbohydrate ?? '0'}g — Gorduras: ${nutrition.fat ?? '0'}g`;
                })
                .catch(err => {
                    console.error('Erro no fetch:', err);
                    document.getElementById('modalName').textContent = 'Erro ao carregar dados';
                });
        });

        // 2. Lógica para FECHAR o Modal (Botão X)
        const closeBtn = document.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                document.getElementById('recipeModal').style.display = 'none';
            });
        }

        // Fechar ao clicar fora do modal (opcional, mas bom para UX)
        const modalOverlay = document.getElementById('recipeModal');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    modalOverlay.style.display = 'none';
                }
            });
        }

    }); // Fim do DOMContentLoaded
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