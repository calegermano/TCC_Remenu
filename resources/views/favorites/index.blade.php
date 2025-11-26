<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da Remenu</title>
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
 
  <link rel="stylesheet" href="{{ asset('css/favoritos.css') }}">
  
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
    <!-- fim nav bar -->

    <section class="favoritos-banner"></section>
        

<div class="conteudo">
    <!-- A div vira a dona da classe -->
    <div class="titulo text-center my-2"> 
        <h1>Minhas receitas favoritas</h1>
    </div>
</div>

@section('content')
<div class="container py-5">
    <div class="receitas-title">
        <h1>Meus Favoritos</h1>
        <p>Suas receitas salvas para acesso rápido.</p>
    </div>

    @if($favoritos->isEmpty())
        <div class="text-center mt-5">
            <i class="bi bi-heartbreak" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-3 text-muted">Você ainda não favoritou nenhuma receita.</p>
            <a href="/receitas" class="btn btn-primary mt-2">Explorar Receitas</a>
        </div>
    @else
        <div class="recipes-grid">
            @foreach($favoritos as $fav)
                <!-- Note que usamos $fav->recipe_id e $fav->name vindos do banco -->
                <div class="recipe-card" data-id="{{ $fav->recipe_id }}">
                    
                    <!-- Botão para remover dos favoritos nesta tela -->
                    <button class="btn-favorite active" 
                            data-id="{{ $fav->recipe_id }}"
                            onclick="toggleFavorite(event, this)">
                        <i class="bi bi-heart-fill"></i>
                    </button>

                    <img 
                        src="{{ $fav->image && $fav->image != '' ? $fav->image : asset('assets/img/semImagem.jpeg') }}" 
                        alt="{{ $fav->name }}"
                        onerror="this.onerror=null; this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
                    >
                    <h5 class="mt-2">{{ $fav->name }}</h5>
                    <p>{{ $fav->calories ? $fav->calories . ' kcal' : 'N/A' }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
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
<script>
    // Precisamos do Token CSRF do Laravel para POST via fetch
    const csrfToken = "{{ csrf_token() }}";

    function toggleFavorite(event, btn) {
        // Impede que o clique abra o Modal de detalhes
        event.stopPropagation();

        const data = {
            recipe_id: btn.dataset.id,
            name: btn.dataset.name,
            image: btn.dataset.image,
            calories: btn.dataset.calories
        };

        // Animação visual imediata (UX)
        const icon = btn.querySelector('i');
        const isActive = btn.classList.contains('active');
        
        if (isActive) {
            btn.classList.remove('active');
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        } else {
            btn.classList.add('active');
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        }

        // Envia para o backend
        fetch('/favoritos/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            console.log(res.status);
        })
        .catch(err => {
            console.error(err);
            // Reverte se der erro
            alert('Erro ao favoritar. Tente novamente.');
        });
    }
</script>

    <!-- Footer -->
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
                      <li><a href="#" class="footer-link"><i class="fas fa-home"></i> Home</a></li>
                      <li><a href="#" class="footer-link"><i class="fas fa-utensils"></i> Receitas</a></li>
                  </ul>
                  <ul class="list-unstyled footer-nav-col">
                      <li><a href="#" class="footer-link"><i class="fas fa-calendar-alt"></i> Planejamento</a></li>
                      <li><a href="#" class="footer-link"><i class="far fa-heart"></i> Favoritos</a></li>
                  </ul><ul class="list-unstyled footer-nav-col">
                      <li><a href="#" class="footer-link"><i class="fas fa-snowflake"></i> Geladeira</a></li>
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

    
<body>