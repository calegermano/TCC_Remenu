<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remenu</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 


    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-item-center fw-semibold" href="resources/views/home.blade.php">
            <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2">
            </a>

            <!-- botão -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!--links menu-->
            <div class="collapse navbar-collapse justify content-end" id="menuNav">
                <ul class ="navbar-nav mb-2 mb-">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Início</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Receitas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="#"></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="#">Planejamento</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link active"  href="#">Favoritos</a>
                    </li>


                     <li class="nav-item">
                        <a class="nav-link active" href="#">Minha Geladeira</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!--seçao principal-->
        <section class="hero text-center py-5">
            <div class="container">
                <h1 class="fw-bold">
                Transforme seus <span class="text-green">ingredientes</span> <br>em receitas <span
                class="text-blue">Incríveis</span>
                </h1>
                <p class="mt-3 text-muted">
                A primeira plataforma focada em reduzir desperdício alimentar.<br>
                Descubra receitas saudáveis baseadas nos ingredientes que você já tem em casa!
                </p>
                <button class="btn-gradient mt-4 px-4 py-2 shadow">Veja mais</button>
            </div>
        </section>

        <section>
            <img src="{{asset('assets/img/home.png')}}" alt="Receitas" class="img-fluid mb-4 rounded">
        </section>
        
        <section class="py-5" style="background: #f8f9fa;">
            <div class="container text-center">
                <h2 class="fw-bold mb-3">Tudo que você precisa em um só lugar</h2>
                <p class="mb-5 text-muted">
                Ferramentas inteligentes para transformar sua cozinha em um espaço sem desperdício
                </p>

                <div class="row g-4 justify-content-center">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <span style="font-size: 2rem; color: #26C485;"><i class="bi bi-search"></i></span>
                                <h5 class="card-title mt-3" style="color: #26C485;">Buscar receitas</h5>
                                <p class="card-text">Digite até 3 ingredientes que você tem em casa e descubra receitas perfeitas. Filtre por tempo, dificuldade e muito mais!</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <span style="font-size: 2rem; color: #FF871E;"><i class="bi bi-heart"></i></span>
                                <h5 class="card-title mt-3" style="color: #FF871E;">Meus Favoritos</h5>
                                <p class="card-text">Salve suas receitas preferidas e acesse-as rapidamente. Nunca mais perca uma receita especial!</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <span style="font-size: 2rem; color: #26C485;"><i class="bi bi-calendar"></i></span>
                                <h5 class="card-title mt-3" style="color: #26C485;">Planejamento</h5>
                                <p class="card-text">Organize suas refeições da semana inteira. Evite desperdício e economize tempo e dinheiro!</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <span style="font-size: 2rem; color: #FF871E;"><i class="bi bi-box"></i></span>
                                <h5 class="card-title mt-3" style="color: #FF871E;">Minha Geladeira</h5>
                                <p class="card-text">Controle os ingredientes que você tem em casa. Receba alertas antes que estraguem!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
