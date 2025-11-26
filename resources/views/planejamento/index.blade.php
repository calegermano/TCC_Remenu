<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Planejamento - Remenu</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
 
  <!-- SEU CSS ORIGINAL -->
  <link rel="stylesheet" href="{{ asset('css/planejamento.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}"> <!-- Importante para o estilo do Modal de Detalhes -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    <!-- Navbar -->
<!-- Navbar Corrigida -->
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
            <div class="collapse navbar-collapse " id="menuNav">
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

                        <!-- Início do Dropdown de Perfil -->
            <div class="dropdown d-none d-lg-block">
                <a href="#" class="profile-link dropdown-toggle text-decoration-none" 
                id="profileDropdown" 
                role="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                    <i class="bi bi-person-fill" style="font-size: 1.5rem; color: #333;"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <!-- NOME DO USUÁRIO AQUI -->
                    <li>
                        <span class="dropdown-item-text fw-bold text-center" style="color: #D9682B;">
                            <!-- Tente 'name' primeiro. Se não aparecer nada, mude para 'nome' -->
                            Olá, {{ Auth::user()->name ?? Auth::user()->nome ?? 'Visitante' }}
                        </span>
                    </li>
                    
                    <li><hr class="dropdown-divider"></li>

                    <!-- Botão de Sair -->
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>            
    </nav>
    
    <div class="hero"></div>

    <div class="conteudo-texto" style="text-align: center; margin: 4rem 0;">
        <h1 class="subtitulo">Planejamento de Refeições</h1>
        <p class="subtexto">Organize suas refeições da semana e economize tempo e dinheiro</p>
    </div>

    <div class="planner-wrapper">
    <!-- Removi o .month-selector daqui de cima -->

        <div class="main-container">
        
        <!-- NOVA DIV: Agrupa o título e o calendário na esquerda -->
            <div class="calendar-column">
            
                <!-- O seletor agora está aqui dentro -->
                <div class="month-selector">
                    <button id="btn-prev" class="nav-btn">← Anterior</button>
                    <h2 id="current-month">Mês</h2>
                    <button id="btn-next" class="nav-btn">Próxima →</button>
                </div>

            <!-- O Grid do calendário logo abaixo -->
                <div class="calendar-grid" id="calendar"></div>
    </div>

        <!-- A Sidebar continua aqui na direita, separada -->
        <aside class="sidebar">
            <div class="sidebar-header" style="margin-bottom: 15px; font-weight: bold; font-size: 1.1rem;">
                <span>👨‍🍳</span> Resumo semanal
            </div>
            <!-- ... resto do conteúdo da sidebar ... -->
             <div class="counter-card" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                <div class="counter-number" id="total-meals" style="font-size: 2rem; font-weight: bold; color: #ff6600;">0</div>
                <div class="counter-label">Refeições planejadas</div>
            </div>
                <div class="stats-list">
                    <div class="stat-item" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Calorias totais:</span>
                        <span id="total-cals" style="font-weight: bold;">0 kcal</span>
                    </div>
                    <div class="stat-item" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Proteínas:</span>
                        <span id="total-prot" style="font-weight: bold;">0g</span>
                    </div>
                    <div class="stat-item" style="display: flex; justify-content: space-between;">
                        <span>Carboidratos:</span>
                        <span id="total-carbs" style="font-weight: bold;">0g</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- 1. MODAL DE SELEÇÃO (Com opção de repetir) -->
    <div id="selectionModal" class="recipe-selection-modal">
        <div class="selection-content">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                <h4 style="margin:0;">Escolha uma receita</h4>
                <button onclick="closeModal()" style="border:none; background:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            
            <!-- Checkbox para Repetir -->
    <div class="form-check form-switch d-flex align-items-center p-3 mb-3" style="background: #fff8f0; border-radius: 10px; border: 1px dashed #e67e22; padding-left: 1rem !important;">
    <!-- m-0 remove a margem negativa que joga o botão pra fora -->
        <input class="form-check-input m-0" type="checkbox" id="repeatCheck" style="width: 3em; height: 1.5em; cursor: pointer; flex-shrink: 0;">
    
    <!-- ms-3 dá o espaço entre o botão e o texto -->
        <label class="form-check-label ms-3" for="repeatCheck" style="cursor: pointer;">
            <strong>Repetir na semana toda</strong> <br>
            <small class="text-muted">Adiciona essa refeição em todos os dias</small>
        </label>
    </div>

            <div id="favoritesList">
                @if(isset($favoritos) && $favoritos->count() > 0)
                    @foreach($favoritos as $fav)
                        <div class="select-item" 
                             onclick="selectRecipe('{{$fav->recipe_id}}', '{{ addslashes($fav->name) }}', '{{$fav->image}}', '{{$fav->calories}}')">
                            <img src="{{ $fav->image ?: asset('assets/img/semImagem.jpeg') }}" 
                                 onerror="this.src='{{ asset('assets/img/semImagem.jpeg') }}'">
                            <div>
                                <div style="font-weight:600;">{{ $fav->name }}</div>
                                <small style="color:#777;">{{ $fav->calories }} kcal</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align:center; padding:20px;">
                        <p>Você ainda não tem favoritos.</p>
                        <a href="receitas" style="color:#2ecc71; text-decoration:none; font-weight:bold;">Ir para Receitas</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. MODAL DE DETALHES DA RECEITA (Para ver o que foi planejado) -->
    <div id="recipeModal" class="modal-overlay" style="display: none;">
      <div class="modal-card">
          <button class="close-modal" onclick="closeDetails()">X</button>
          <img id="modalImage" src="" alt="">
          <h2 id="modalName"></h2>
          <p><strong>Calorias:</strong> <span id="modalCalories"></span></p>
          <p><strong>Tempo de preparo:</strong> <span id="modalPrep"></span></p>

          <h4>Ingredientes</h4>
          <ul id="modalIngredients"></ul>

          <h4>Modo de preparo</h4>
          <div id="modalDirections"></div>

          <hr>
          <h4>Informação Nutricional</h4>
          <p id="modalNutrition"></p>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const mealTypes = ['Café da manhã', 'Almoço', 'Jantar'];
        
        let referenceDate = new Date(); 
        let currentPlans = []; 
        let selectedSlotData = { date: null, type: null }; 

        const calendarContainer = document.getElementById('calendar');
        const monthTitle = document.getElementById('current-month');
        const els = {
            meals: document.getElementById('total-meals'),
            cals: document.getElementById('total-cals'),
            prot: document.getElementById('total-prot'),
            carbs: document.getElementById('total-carbs')
        };

        // 1. Data
        function getWeekDays() {
            const currentDay = referenceDate.getDay(); 
            const distanceToMonday = (currentDay + 6) % 7; 
            const monday = new Date(referenceDate);
            monday.setDate(referenceDate.getDate() - distanceToMonday);

            monthTitle.innerText = monday.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });

            const week = [];
            for (let i = 0; i < 7; i++) {
                const day = new Date(monday);
                day.setDate(monday.getDate() + i);
                const sqlDate = day.toISOString().split('T')[0];

                week.push({
                    name: day.toLocaleDateString('pt-BR', { weekday: 'short' }).replace('.', ''),
                    displayDate: day.getDate(),
                    fullDate: sqlDate,
                    isToday: new Date().toDateString() === day.toDateString()
                });
            }
            return week;
        }

        // 2. Fetch
        async function fetchPlans() {
            const week = getWeekDays();
            const start = week[0].fullDate;
            const end = week[6].fullDate;

            renderCalendar(week); // Desenha esqueleto

            try {
                const res = await fetch(`/planejamento/fetch?start=${start}&end=${end}`);
                if(!res.ok) throw new Error("Erro API");
                currentPlans = await res.json();
                renderCalendar(week); 
                updateSidebar();
            } catch (err) {
                console.error("Erro:", err);
            }
        }

        // 3. Render
        function renderCalendar(weekDays) {
            calendarContainer.innerHTML = ''; 

            weekDays.forEach(day => {
                const dayCol = document.createElement('div');
                dayCol.className = day.isToday ? 'day-column today' : 'day-column';

                const header = document.createElement('div');
                header.className = 'day-header';
                header.innerHTML = `
                    <span class="day-name">${day.name}</span>
                    <span class="day-number">${day.displayDate}</span>
                `;
                dayCol.appendChild(header);

                mealTypes.forEach(type => {
                    const plan = currentPlans.find(p => p.date === day.fullDate && p.meal_type === type);
                    const slot = document.createElement('div');
                    
                    if (plan) {
                        slot.className = 'meal-slot filled'; 
                        slot.innerHTML = `
                            <span>${type}</span>
                            <div class="recipe-name">${plan.recipe_name}</div>
                            <div class="cal-info">${Math.round(plan.calories)} kcal</div>
                            <div class="remove-btn" title="Remover" onclick="removePlan(${plan.id}, event)">×</div>
                        `;
                        // NOVIDADE: Clicar no slot abre detalhes
                        slot.onclick = (e) => {
                            if (!e.target.classList.contains('remove-btn')) {
                                openDetails(plan.recipe_id);
                            }
                        }
                    } else {
                        slot.className = 'meal-slot';
                        slot.innerHTML = `<span>${type}</span><div style="font-size:1.5rem; color:#ccc;">+</div>`;
                        slot.onclick = () => openSelectionModal(day.fullDate, type);
                    }
                    dayCol.appendChild(slot);
                });
                calendarContainer.appendChild(dayCol);
            });
        }

        // 4. Modal de Seleção
        function openSelectionModal(date, type) {
            selectedSlotData = { date, type };
            document.getElementById('repeatCheck').checked = false; // Reseta checkbox
            document.getElementById('selectionModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('selectionModal').style.display = 'none';
        }

        // 5. Salvar (COM LÓGICA DE REPETIR)
        async function selectRecipe(id, name, image, calories) {
            closeModal();
            let protein = 0, carbs = 0;
            const repeat = document.getElementById('repeatCheck').checked;

            // Busca Macros
            try {
                const resApi = await fetch(`/receitas/${id}`);
                const dataApi = await resApi.json();
                if (dataApi.recipe && dataApi.recipe.serving_sizes && dataApi.recipe.serving_sizes.serving) {
                    let s = dataApi.recipe.serving_sizes.serving;
                    if(Array.isArray(s)) s = s[0];
                    protein = parseFloat(s.protein || 0);
                    carbs = parseFloat(s.carbohydrate || 0);
                }
            } catch(e) { }

            const safeCalories = calories ? parseFloat(calories) : 0;
            const safeName = name || 'Receita';

            // Define quais dias salvar
            let datesToSave = [];
            
            if (repeat) {
                // Pega todos os dias da semana atual
                const week = getWeekDays();
                datesToSave = week.map(d => d.fullDate);
            } else {
                // Só o dia clicado
                datesToSave = [selectedSlotData.date];
            }

            // Loop para salvar (simples e não quebra o backend atual)
            let successCount = 0;
            
            // Exibir loading ou algo seria bom, mas vamos manter simples
            for (const date of datesToSave) {
                const payload = {
                    recipe_id: id,
                    date: date, // Usa a data do loop
                    meal_type: selectedSlotData.type,
                    recipe_name: safeName,
                    recipe_image: image || '',
                    calories: safeCalories,
                    protein: protein,
                    carbs: carbs
                };

                try {
                    const res = await fetch('/planejamento/store', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify(payload)
                    });
                    const json = await res.json();
                    if (json.status === 'success') successCount++;
                } catch (err) { console.error(err); }
            }

            if (successCount > 0) {
                fetchPlans(); // Atualiza tudo no final
            } else {
                alert('Erro ao salvar planejamento.');
            }
        }

        // 6. Remover
        async function removePlan(id, event) {
            event.stopPropagation();
            if(!confirm("Remover refeição?")) return;
            try {
                await fetch(`/planejamento/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } });
                fetchPlans();
            } catch (err) { alert('Erro ao remover.'); }
        }

        // 7. Stats
        function updateSidebar() {
            let totalMeals = currentPlans.length;
            let totalC = 0, totalP = 0, totalCb = 0;
            currentPlans.forEach(p => {
                totalC += parseFloat(p.calories || 0);
                totalP += parseFloat(p.protein || 0);
                totalCb += parseFloat(p.carbs || 0);
            });
            els.meals.innerText = totalMeals;
            els.cals.innerText = Math.round(totalC) + ' kcal';
            els.prot.innerText = Math.round(totalP) + 'g';
            els.carbs.innerText = Math.round(totalCb) + 'g';
        }

        // 8. Visualizar Detalhes (NOVA FUNÇÃO)
        function openDetails(id) {
            const modal = document.getElementById('recipeModal');
            modal.style.display = 'flex';
            document.getElementById('modalName').textContent = 'Carregando...';
            document.getElementById('modalImage').src = '{{ asset("assets/img/semImagem.jpeg") }}'; // Ajustado

            // Limpa
            document.getElementById('modalCalories').textContent = '';
            document.getElementById('modalPrep').textContent = '';
            document.getElementById('modalIngredients').innerHTML = '';
            document.getElementById('modalDirections').innerHTML = '';
            document.getElementById('modalNutrition').textContent = '';

            fetch(`/receitas/${id}`)
                .then(res => res.json())
                .then(data => {
                    const r = data.recipe;
                    if (!r) return;

                    let nutrition = {};
                    if (r.serving_sizes && r.serving_sizes.serving) {
                        const s = r.serving_sizes.serving;
                        nutrition = Array.isArray(s) ? s[0] : s;
                    }

                    document.getElementById('modalName').textContent = r.recipe_name ?? '—';

                    let imgSrc = '{{ asset("assets/img/semImagem.jpeg") }}';
                    if (r.recipe_image) imgSrc = r.recipe_image;
                    else if (r.recipe_images && r.recipe_images.recipe_image) {
                        let imgs = r.recipe_images.recipe_image;
                        imgSrc = Array.isArray(imgs) ? imgs[0] : imgs;
                    }
                    document.getElementById('modalImage').src = imgSrc;

                    document.getElementById('modalCalories').textContent = nutrition.calories ?? 'N/A';

                    const prep = parseInt(r.preparation_time_min ?? 0);
                    const cook = parseInt(r.cooking_time_min ?? 0);
                    const total = prep + cook;
                    document.getElementById('modalPrep').textContent = total > 0 ? total + ' min' : 'N/A';

                    // Ingredientes
                    const ingList = document.getElementById('modalIngredients');
                    ingList.innerHTML = '';
                    let ingredientsRaw = [];
                    if (r.ingredients && r.ingredients.ingredient) ingredientsRaw = r.ingredients.ingredient;
                    if (!Array.isArray(ingredientsRaw) && ingredientsRaw) ingredientsRaw = [ingredientsRaw];

                    if (ingredientsRaw.length > 0) {
                        ingredientsRaw.forEach(item => {
                            const li = document.createElement('li');
                            const text = item.ingredient_description ?? item.food_name ?? item;
                            const measurement = item.measurement_description ?? '';
                            li.textContent = measurement ? `${measurement} ${text}` : text;
                            ingList.appendChild(li);
                        });
                    } else { ingList.innerHTML = '<li>Sem ingredientes.</li>'; }

                    // Preparo
                    const directionsContainer = document.getElementById('modalDirections');
                    directionsContainer.innerHTML = ''; 
                    let directionsRaw = [];
                    if (r.directions && r.directions.direction) directionsRaw = r.directions.direction;
                    if (!Array.isArray(directionsRaw) && directionsRaw) directionsRaw = [directionsRaw];

                    if (directionsRaw.length > 0) {
                        directionsRaw.sort((a, b) => (a.direction_number - b.direction_number));
                        directionsRaw.forEach(step => {
                            const p = document.createElement('p');
                            p.style.marginBottom = "8px";
                            p.textContent = `${step.direction_number ? step.direction_number + '.' : '•'} ${step.direction_description}`;
                            directionsContainer.appendChild(p);
                        });
                    } else { directionsContainer.textContent = r.recipe_description ?? 'Modo de preparo não disponível.'; }

                    document.getElementById('modalNutrition').textContent =
                        `Proteínas: ${nutrition.protein ?? '0'}g — Carboidratos: ${nutrition.carbohydrate ?? '0'}g — Gorduras: ${nutrition.fat ?? '0'}g`;
                })
                .catch(console.error);
        }

        function closeDetails() {
            document.getElementById('recipeModal').style.display = 'none';
        }

        // Eventos
        document.getElementById('btn-prev').addEventListener('click', () => {
            referenceDate.setDate(referenceDate.getDate() - 7);
            fetchPlans();
        });

        document.getElementById('btn-next').addEventListener('click', () => {
            referenceDate.setDate(referenceDate.getDate() + 7);
            fetchPlans();
        });

        document.getElementById('selectionModal').addEventListener('click', (e) => {
            if (e.target.id === 'selectionModal') closeModal();
        });
        document.getElementById('recipeModal').addEventListener('click', (e) => {
            if (e.target.id === 'recipeModal') closeDetails();
        });

        fetchPlans();
    </script>
</body>
</html>