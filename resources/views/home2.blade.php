<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Início - Remenu</title>

  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/home2.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>
<body>
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
                        <a class="nav-link active" href="{{ route('home2') }}">Início</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('recipes.index') }}">Receitas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('planejamento') }}">Planejamento</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link active"  href="{{ route('favoritos') }}">Favoritos</a>
                    </li>


                     <li class="nav-item">
                        <a class="nav-link active" href="{{ route('geladeira') }}">Minha Geladeira</a>
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

  <div class="fundo-imagem">
    <img src="assets/img/logo.png" alt="Logo central" class="imagem-centro">
  </div>

  <!-- Seção principal -->
<section class="banner">
  <div class="container d-flex align-items-center justify-content-between flex-wrap">
    
    <!-- Texto à esquerda -->
    <div class="texto-banner col-12 col-md-6 mb-4 mb-md-0">
      <h2 class="fw-bold">
        Transforme ingredientes que você já tem em casa em receitas deliciosas e saudáveis.
      </h2>
      <a href="{{ route('recipes.index') }}" class="btn btn-banner mt-3">
        Explore as receitas →
      </a>
    </div>

    <!-- Imagem à direita -->
    <div class="imagem-banner col-12 col-md-5 text-center text-md-end">
      <img src="../assets/img/card1.jpg" alt="Imagem de receita" class="img-fluid imagem-arredondada">
    </div>

  </div>
</section>


<section class="receita-dia py-5">
  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="texto me-lg-5 mb-4 mb-lg-0">
      <h3 class="receita-titulo fw-bold mb-3">Receita de hoje</h3>
      <p class="receita-paragrafo mb-4">Para programar sua receita do dia utilize o planejamento da Remenu!</p>
      <a href="{{ route('planejamento') }}" class="btn btn-planejar mt-3">Planeje suas refeições →</a>
    </div>

    <div class="imagens">
      <img src="{{ asset('assets/img/card2.jpg') }}" class="img-principal" alt="Tigela de Açaí e frutas">
      <img src="../assets/img/card3.jpg" class="img-secundaria" alt="Salada com atum e ovos">
      <img src="../assets/img/card4.jpg" class="img-secundaria2" alt="Torrada com abacate e ovos">
    </div>
  </div>
</section>


<section class="receitas-destaque py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h3 class="receitas-titulo fw-bold mx-auto">Receitas em destaque</h3>
      <a href="{{ route('recipes.index') }}" class="btn btn-veja-mais btn-sm">Veja mais</a>
    </div>

    <!-- Usamos o Grid do Bootstrap para organizar os 3 cards -->
    <div class="row justify-content-center g-4">
      
      @forelse($destaques as $receita)
        <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
            
            <!-- CARD COM O ESTILO ORIGINAL DA PÁGINA DE RECEITAS -->
            <!-- Adicionei 'w-100' para ele ocupar a largura da coluna do bootstrap -->
            <div class="recipe-card w-100" data-id="{{ $receita['recipe_id'] }}">
                
                <!-- A imagem já tem o estilo no index.css -->
                <img 
                    src="{{ $receita['recipe_image'] ?? asset('assets/img/semImagem.jpeg') }}" 
                    alt="{{ $receita['recipe_name'] }}"
                    onerror="this.src='{{ asset('assets/img/semImagem.jpeg') }}';"
                >
                
                <h5 class="mt-2">{{ $receita['recipe_name'] }}</h5>
                
                <!-- Se quiser mostrar calorias igual na outra página -->
                <p>{{ $receita['recipe_nutrition']['calories'] ?? 'N/A' }} kcal</p>

                <!-- Link disfarçado para levar aos detalhes -->
                <a href="{{ route('recipes.index') }}" class="stretched-link"></a>
            </div>

        </div>
      @empty
        <div class="col-12 text-center">
            <p>Carregando destaques...</p>
        </div>
      @endforelse

    </div>
  </div>
</section>

 <section class="recursos py-5">
  <div class="container">
    <h3 class="recursos-titulo fw-bold mb-5">Descubra tudo que a REMENU oferece!</h3>
    
    <div class="row g-4 justify-content-center">
      
      <div class="col-12 col-md-4">
        <div class="card p-3 h-100 recurso-card text-start">
          <h5 class="recurso-card-title text-center">Meus favoritos</h5>
          
          <img src="../assets/img/salada.jpg" class="card-img-top recurso-card-img" alt="Salada colorida em uma tigela">

          <div class="card-body">
            <p class="card-text recurso-card-text">
                Salve suas receitas preferidas em um só lugar! Acesse rapidamente aquelas que mais gosta e nunca mais perca uma receita especial.
            </p>
            <a href="{{ route('favoritos') }}" class="btn btn-recurso mt-auto">Ver favoritos</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="card p-3 h-100 recurso-card text-start">
          <h5 class="recurso-card-title text-center">Planejamento</h5>
          
          <img src="../assets/img/planejamento.jpg" class="card-img-top recurso-card-img" alt="Refeições prontas em potes">

          <div class="card-body">
            <p class="card-text recurso-card-text">
                Organize suas refeições da semana de forma inteligente! Evite desperdício, economize tempo e tenha sempre um prato saudável pronto.
            </p>
            <a href="{{ route('planejamento') }}" class="btn btn-recurso mt-auto">Ver planejamento</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="card p-3 h-100 recurso-card text-start">
          <h5 class="recurso-card-title text-center">Geladeira</h5>
          
          <img src="../assets/img/vegetais.jpg" class="card-img-top recurso-card-img" alt="Vegetais frescos na tábua de corte">

          <div class="card-body">
            <p class="card-text recurso-card-text">
                Controle os ingredientes que você tem em casa! Receba sugestões de receitas baseadas nos seus ingredientes e nunca deixe nada estragar.
            </p>
            <a href="{{ route('geladeira') }}" class="btn btn-recurso mt-auto">Ver geladeira</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
                      <li><a href="{{ route('home2') }}" class="footer-link"><i class="fas fa-home"></i> Home</a></li>
                      <li><a href="{{ route('recipes.index') }}" class="footer-link"><i class="fas fa-utensils"></i> Receitas</a></li>
                  </ul>
                  <ul class="list-unstyled footer-nav-col">
                      <li><a href="{{ route('planejamento') }}" class="footer-link"><i class="fas fa-calendar-alt"></i> Planejamento</a></li>
                      <li><a href="{{ route('favoritos') }}" class="footer-link"><i class="far fa-heart"></i> Favoritos</a></li>
                  </ul><ul class="list-unstyled footer-nav-col">
                      <li><a href="{{ route('geladeira') }}" class="footer-link"><i class="fas fa-snowflake"></i> Geladeira</a></li>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Importa header e footer
    fetch("componentes/header.html").then(r => r.text()).then(d => document.getElementById("header").innerHTML = d);
    fetch("componentes/footer.html").then(r => r.text()).then(d => document.getElementById("footer").innerHTML = d);
  </script>
</body>
</html>
