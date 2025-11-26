<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da Remenu</title>
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
 
  <link rel="stylesheet" href="{{ asset('css/planejamento.css') }}">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

  <style>
        :root {
            --bg-color: #ffffff;
            --card-bg: #dcdcdc;
            --slot-bg: #ffffff;
            --text-color: #5d6d7e;
            --accent-color: #e67e22;
            --font-family: 'Poppins', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        /* Hero / Banner */
        .hero {
            width: 100%;
            height: 250px;
            background-image: url('https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?q=80&w=1470&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            margin-bottom: 30px;
        }

        .conteudo-texto {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .titulo { color: #2ecc71; font-weight: 600; }
        .subtexto { color: #7f8c8d; }

        /* Container Principal */
        .planner-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            width: 100%;
        }

        /* Seletor de Mês */
        .month-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        .month-selector h2 {
            font-size: 1.8rem;
            color: var(--text-color);
            margin: 0;
            text-transform: capitalize;
            min-width: 200px; /* Evita pulos quando muda o nome do mês */
            text-align: center;
        }

        .nav-btn {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.2rem;
            user-select: none; /* Evita selecionar o texto ao clicar rápido */
        }
        .nav-btn:hover { opacity: 0.8; }
        .nav-btn:active { transform: scale(0.95); }

        /* Grid Layout */
        .main-container {
            display: flex;
            gap: 40px;
            align-items: flex-start;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            max-width: 800px;
            width: 100%;
        }

        .day-column {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 15px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 130px;
            transition: 0.3s;
        }

        /* Destaque para o dia atual */
        .day-column.today {
            border: 2px solid var(--accent-color);
            i
            box-shadow: 0 0 10px rgba(230, 126, 34, 0.3);
        }

        .day-header { text-align: center; margin-bottom: 15px; }
        .day-name { font-size: 1.2rem; font-weight: bold; display: block; text-transform: capitalize; }
        .day-number { font-size: 1.1rem; font-weight: bold; }

        .meal-slot {
            background-color: var(--slot-bg);
            width: 100%;
            border-radius: 8px;
            padding: 15px 5px;
            margin-bottom: 10px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            border: 2px solid transparent;
        }
        .meal-slot:hover { transform: translateY(-2px); box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .meal-slot.active { border-color: var(--accent-color); background-color: #fff8f0; }
        .meal-slot span { display: block; font-size: 0.85rem; font-weight: 500; }
        .plus-sign { font-size: 1.2rem; color: #aaa; margin-top: 5px; }

        /* Sidebar */
        .sidebar {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 15px;
            width: 280px;
            text-align: center;
        }
        .sidebar-header {
            color: var(--accent-color);
            font-weight: bold; font-size: 1.1rem; margin-bottom: 20px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .counter-card {
            background-color: white; border-radius: 10px; padding: 20px; margin-bottom: 20px;
        }
        .counter-number { font-size: 1.5rem; font-weight: bold; color: var(--text-color); }
        .counter-label { font-size: 0.9rem; color: #888; }
        .stats-list { text-align: left; font-size: 0.95rem; color: var(--text-color); }
        .stat-item { display: flex; justify-content: space-between; margin-bottom: 8px; }

        @media (max-width: 1100px) { .calendar-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) {
            .calendar-grid { grid-template-columns: repeat(2, 1fr); }
            .main-container { flex-direction: column-reverse; align-items: center; }
        }
        @media (max-width: 480px) { .calendar-grid { grid-template-columns: 1fr; } }
  </style>
</head>

<body>


    <!-- Navbar -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Receitas da Remenu</title>
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
 
  <link rel="stylesheet" href="{{ asset('css/planejamento.css') }}">
  
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
    
    <div class="hero"></div>

    <div class="conteudo-texto">
        <h1 class="titulo">Planejamento de Refeições</h1>
        <p class="subtexto">Organize suas refeições da semana e economize tempo e dinheiro</p>
    </div>

    <!-- Wrapper do Planejador -->
    <div class="planner-wrapper">
        <div class="month-selector">
            <!-- Adicionei IDs nos botões -->
            <button id="btn-prev" class="nav-btn">←</button>
            <h2 id="current-month">Mês</h2>
            <button id="btn-next" class="nav-btn">→</button>
        </div>

        <div class="main-container">
            <div class="calendar-grid" id="calendar"></div>

            <aside class="sidebar">
                <div class="sidebar-header">
                    <span>👨‍🍳</span> Resumo semanal
                </div>
                <div class="counter-card">
                    <div class="counter-number" id="total-meals">0</div>
                    <div class="counter-label">Refeições planejadas</div>
                </div>
                <div class="stats-list">
                    <div class="stat-item">
                        <span>Calorias totais:</span>
                        <span id="total-cals">0 kcal</span>
                    </div>
                    <div class="stat-item">
                        <span>Proteínas:</span>
                        <span id="total-prot">0g</span>
                    </div>
                    <div class="stat-item">
                        <span>Carboidratos:</span>
                        <span id="total-carbs">0g</span>
                    </div>
                </div>
            </aside>
        </div>
    </div> 

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* --- JavaScript Lógica Atualizada com Navegação --- */
        
        const mealTypes = ['Café da manhã', 'Almoço', 'Jantar'];
        let plannedMealsCount = 0;
        const stats = { cals: 0, prot: 0, carbs: 0 };

        // Variável de estado para controlar a data atual do calendário
        // Inicializa com a data de hoje
        let referenceDate = new Date(); 

        const calendarContainer = document.getElementById('calendar');
        const monthTitle = document.getElementById('current-month');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        const totalMealsEl = document.getElementById('total-meals');
        const totalCalsEl = document.getElementById('total-cals');
        const totalProtEl = document.getElementById('total-prot');
        const totalCarbsEl = document.getElementById('total-carbs');

        // Função que calcula os dias baseada na 'referenceDate'
        function getWeekDays() {
            // Data "real" de hoje (para comparação de destaque visual)
            const actualToday = new Date();

            // Pega o dia da semana da data de referência (0=Dom, 1=Seg...)
            const currentDay = referenceDate.getDay(); 
            
            // Calcula distância até a última segunda-feira
            // Se Domingo (0) -> volta 6 dias. Se Segunda (1) -> volta 0.
            const distanceToMonday = (currentDay + 6) % 7; 
            
            const monday = new Date(referenceDate);
            monday.setDate(referenceDate.getDate() - distanceToMonday);

            // Atualiza Título do Mês
            // Se a semana cruza meses (ex: 30 Set - 06 Out), mostra o mês da segunda-feira
            const monthName = monday.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
            monthTitle.innerText = monthName;

            const week = [];
            // Gera os 7 dias
            for (let i = 0; i < 7; i++) {
                const day = new Date(monday);
                day.setDate(monday.getDate() + i);

                week.push({
                    name: day.toLocaleDateString('pt-BR', { weekday: 'short' }).replace('.', ''),
                    date: day.getDate(),
                    // Verifica se esse dia gerado é igual ao dia real do sistema
                    isToday: day.toDateString() === actualToday.toDateString()
                });
            }
            return week;
        }

        function renderCalendar() {
            const weekDays = getWeekDays();
            calendarContainer.innerHTML = ''; 

            weekDays.forEach(day => {
                const dayCol = document.createElement('div');
                // Se for hoje, adiciona classe 'today' para destaque
                dayCol.className = day.isToday ? 'day-column today' : 'day-column';

                const header = document.createElement('div');
                header.className = 'day-header';
                header.innerHTML = `
                    <span class="day-name">${day.name}</span>
                    <span class="day-number">${day.date}</span>
                `;
                dayCol.appendChild(header);

                mealTypes.forEach(type => {
                    const slot = document.createElement('div');
                    slot.className = 'meal-slot';
                    slot.innerHTML = `<span>${type}</span><div class="plus-sign">+</div>`;
                    slot.addEventListener('click', () => toggleMeal(slot));
                    dayCol.appendChild(slot);
                });
                calendarContainer.appendChild(dayCol);
            });
        }

        // --- Eventos de Navegação ---
        
        // Voltar 1 semana
        btnPrev.addEventListener('click', () => {
            referenceDate.setDate(referenceDate.getDate() - 7);
            renderCalendar();
        });

        // Avançar 1 semana
        btnNext.addEventListener('click', () => {
            referenceDate.setDate(referenceDate.getDate() + 7);
            renderCalendar();
        });

        // --- Lógica de Refeições (igual ao anterior) ---

        function toggleMeal(element) {
            const isActive = element.classList.contains('active');
            if (isActive) {
                element.classList.remove('active');
                plannedMealsCount--;
                stats.cals -= 500; stats.prot -= 30; stats.carbs -= 45;
                element.querySelector('.plus-sign').innerText = '+';
            } else {
                element.classList.add('active');
                plannedMealsCount++;
                stats.cals += 500; stats.prot += 30; stats.carbs += 45;
                element.querySelector('.plus-sign').innerText = '✓';
            }
            updateSidebar();
        }

        function updateSidebar() {
            totalMealsEl.innerText = plannedMealsCount;
            totalCalsEl.innerText = `${stats.cals} kcal`;
            totalProtEl.innerText = `${stats.prot}g`;
            totalCarbsEl.innerText = `${stats.carbs}g`;
        }

        // Inicializar
        renderCalendar();
    </script>
</body>
</html>
</body>
</html>