<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Remenu</title>

  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />


  <link rel="stylesheet" href="{{ asset('css/header.css')}}" />

  <link rel="stylesheet" href="{{ asset('css/home.css')}}" />

  <link rel="stylesheet" href="{{ asset('css/footer.css')}}" />

  
</head>
<body>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg bg-light border-bottom">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center fw-semibold" href="#">
        <img src="assets/img/logo.png" alt="Logo Remenu" width="40" height="40" class="me-2" />
        <span class="titulo">Remenu</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="menuNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="#quem-somos">Quem somos</a></li>
          <li class="nav-item"><a class="nav-link" href="#porque-remenu">Por que escolher</a></li>
          <li class="nav-item"><a class="nav-link active" href="#ferramentas">Ferramentas</a></li>
          <li class="nav-item"><a class="nav-link" href="#como-funciona">Como funciona</a></li>

        </ul>
      </div>

      <a href="{{ asset('/login')}}" class="btn-login d-flex align-items-center" role="button">
        <i class="bi bi-person-fill me-2"></i>
        <span class="d-none d-md-inline">Entrar / Cadastre-se</span>
      </a>

    </div>
  </nav>

  <!-- HERO -->
  <section class="hero text-center py-5">
    <div class="container">
      <h1 class="fw-bold">
        Transforme seus <span class="text-blue">ingredientes</span><br/>
        em receitas <span class="text-blue">incríveis</span>
      </h1>
      <p class="mt-3 text-muted">
        A primeira plataforma focada em reduzir desperdício alimentar.<br />
        Descubra receitas saudáveis baseadas nos ingredientes que você já tem em casa!
      </p>
      <button class="btn-gradient mt-4 px-4 py-2 shadow">Veja mais</button>
    </div>
  </section>

  <!-- PARALLAX -->
  <section class="parallax"></section>

  <section class="quem-somos py-5" id="quem-somos">
    <div class="container text-center">
      <h2 class="titulo-principal">Quem somos?</h2>
      <p class="descricao">
        Somos uma plataforma de receitas dedicada a combater o desperdício alimentar e promover uma alimentação saudável.
      </p>

  <div class="container mt-5">
    <div class="row align-items-center">
      <div class="col-md-6 texto-esquerda">
        <h3 class="subtitulo">Nossa História</h3>
        <p class="texto">
          Aproveite ao máximo todos os ingredientes que você compra. Nossa metodologia já ajudou usuários a reduzir 30% do desperdício.
        </p>
        <p class="texto-esquerda">
          <em>Decidimos criar uma solução local, feita por guarulhenses para guarulhenses, que ajuda a transformar ingredientes em receitas deliciosas, reduzindo desperdício e promovendo uma alimentação mais consciente.</em>
        </p>
      </div>

      <div class="col-md-6">
        <img src="{{ asset('assets/img/quemsomos.jpg') }}" alt="salada colorida" class="img-fluid imagem-historia rounded-4 shadow">
      </div>
    </div>
  </div>


    <!-- Cards com efeito hover -->
    <div class="row mt-5 g-4 justify-content-center">
      <div class="col-md-3">
        <div class="card-accordion">
          <div class="card-header">Nossa Missão</div>
          <div class="card-body">
            Transformar a forma como as pessoas se relacionam com a comida, tornando a cozinha mais sustentável, acessível e prazerosa para todos em Guarulhos.
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-accordion">
          <div class="card-header">Sustentabilidade</div>
          <div class="card-body">
            Acreditamos que pequenas mudanças geram grandes impactos. Cada receita aproveitada é um passo em direção a um futuro mais sustentável.
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-accordion">
          <div class="card-header">Comunidade</div>
            <div class="card-body">
              Somos mais que uma plataforma — somos uma comunidade. Valorizamos cada usuário, cada receita compartilhada e cada história de transformação.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="porque-remenu py-5" id="porque-remenu">
    <div class="container">
      <div class="row align-items-center">
        <!-- Texto -->
        <div class="col-lg-7">
          <h2 class="fw-bold mb-4">Por que escolher a <span class="text-green">REMENU</span>?</h2>
          <div class="beneficio mb-4">
            <i class="bi bi-check2-circle text-green fs-4 me-2"></i>
            <div>
              <h5 class="fw-semibold">Reduz Desperdício Alimentar</h5>
              <p class="text-muted mb-0">
              Aproveite ao máximo todos os ingredientes que você compra. Nossa metodologia já ajudou usuários a reduzir 30% do desperdício.
              </p>
            </div>
          </div>
          <div class="beneficio mb-4">
            <i class="bi bi-check2-circle text-green fs-4 me-2"></i>
            <div>
              <h5 class="fw-semibold">Economiza Tempo e Dinheiro</h5>
              <p class="text-muted mb-0">
                Pare de ficar pensando “o que vou fazer com isso?”. Planeje suas refeições e otimize suas compras.
              </p>
            </div>
          </div>
          <div class="beneficio">
            <i class="bi bi-check2-circle text-green fs-4 me-2"></i>
            <div>
              <h5 class="fw-semibold">Receitas Saudáveis e Saborosas</h5>
              <p class="text-muted mb-0">
                Todas as receitas são testadas e avaliadas pela comunidade. Foco em alimentação saudável e nutritiva.
              </p>
            </div>
          </div>
        </div>
        <!-- Imagem -->
        <div class="col-lg-5 mt-4 mt-lg-0 text-center">
          <img src="assets/img/home.jpg" alt="Prato saudável" class="img-fluid rounded-4 shadow">
        </div>
      </div>
    </div>
  </section>

  
  <!-- CARDS -->
  <section class="section-cards" id="ferramentas" >
    <div class="container text-center">
      <h2 class="fw-bold mb-3">
          Tudo que você precisa em um só lugar
      </h2>
      <p class="mb-5 text-muted">
          Ferramentas inteligentes para transformar sua cozinha em um espaço sem desperdício
      </p>
      <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <span style="font-size: 2rem; color: #26C485;"><i class="bi bi-search"></i></span>
            <h5 class="card-title mt-3" style="color: #26C485;">Buscar receitas</h5>
            <p class="card-text">Digite até 3 ingredientes que você tem em casa e descubra receitas perfeitas.</p>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
              <span style="font-size: 2rem; color: #D9682B;"><i class="bi bi-heart"></i></span>
              <h5 class="card-title mt-3" style="color: #D9682B;">Meus Favoritos</h5>
              <p class="card-text">Salve suas receitas preferidas e acesse-as rapidamente.</p>
            </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <span style="font-size: 2rem; color: #26C485;"><i class="bi bi-calendar"></i></span>
            <h5 class="card-title mt-3" style="color: #26C485;">Planejamento</h5>
            <p class="card-text">Organize suas refeições da semana inteira e evite desperdícios!</p>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <span style="font-size: 2rem; color:  #D9682B;"><i class="bi bi-box"></i></span>
            <h5 class="card-title mt-3" style="color:  #D9682B;">Minha Geladeira</h5>
            <p class="card-text">Controle os ingredientes que você tem e receba alertas antes que estraguem.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="como-funciona py-5" id="como-funciona"  >
    <div class="container text-center">
        <h2 class="fw-bold">Como Funciona?</h2>
            <p class="text-muted mb-5">É simples e rápido!</p>

            <div class="row justify-content-center">
            <!-- Etapa 1 -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="etapa">
                        <div class="etapa-numero">1</div>
                        <h5 class="fw-semibold mt-3">Digite seus ingredientes</h5>
                        <p class="text-muted">
                        Informe até 3 ingredientes que você tem disponível em casa. <br>
                        Pode ser qualquer coisa: tomate, frango, arroz...
                        </p>
                    </div>
                </div>

                <!-- Etapa 2 -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="etapa">
                        <div class="etapa-numero">2</div>
                        <h5 class="fw-semibold mt-3">
                            Descubra Receitas
                        </h5>
                        <p class="text-muted">
                        Encontre receitas perfeitas para seus ingredientes. <br>
                        Filtre por tempo, dificuldade e preferências.
                        </p>
                    </div>
                </div>

                <!-- Etapa 3 -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="etapa">
                        <div class="etapa-numero">3</div>
                        <h5 class="fw-semibold mt-3">Cozinhe e Aproveite!</h5>
                        <p class="text-muted">
                        Siga o passo a passo e crie pratos deliciosos. <br>
                        Avalie, favorite e compartilhe suas experiências!
                        </p>
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
                      <li><a href="home" class="footer-link"><i class="fas fa-home"></i> Home</a></li>
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
  <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Parallax JS -->
<script>
  window.addEventListener("scroll", function () {
    const parallax = document.querySelector(".parallax");
    if (!parallax) return;

    const rect = parallax.getBoundingClientRect();
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const offsetTop = parallax.offsetTop;
    const height = parallax.offsetHeight;
    const windowHeight = window.innerHeight;

    if (scrollTop + windowHeight > offsetTop && scrollTop < offsetTop + height) {
      const yPos = (scrollTop - offsetTop) * 0.8;
      parallax.style.backgroundPosition = `center ${yPos}px`;
    }
  });
</script>
</body>
</html>
