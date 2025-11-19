<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geladeira</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
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
                        <a class="nav-link active" href="receita">Receitas</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <section class="hero-banner">
        <img src='../assets/img/geladeira.jpg'>
    </section>
        </div>
        <section class="titulo">
            <h1>Minha Geladeira</h1>
            <p>Gerencie seus ingredientes e evite desperdícios.</p>
        </section>
        <section class="conteudo">
            <!--Card Adicionar Ingrediente -->
            <div class="card add">
                <h3>+ Adicionar Ingrediente </h3>
                <label>Nome do Ingrediente</label>
                <input type="text">
                <label>Quantidade (Opcional)</label>
                <input type="text">
                <label>Categoria</label>
                <select>
                    <option>Outros</option>
                    <option>Vegetais</option>
                    <option>Proteínas</option>
                    <option>Laticínios</option>
                </select>
                <button>Adicionar</button>
            </div>

            <!--Card Meus Ingredientes-->
            <div class="card meus-ingredientes">
                <h3><i class="bi bi-box-seam"></i> Meus Ingredientes</h3>
                <div class="categoria">
                    <h4>Vegetais</h4>
                    </div>
                    
                </div>
                <div class="categoria">
                    <h4>Proteínas</h4>
                </div>

                <div class="categoria">
                    <h4>Laticínios</h4>
                    </div>
                </div>
            </div>

        <!-- Ingredientes Básicos -->
         <div class="card basicos">
            <h3>Ingredientes Básicos</h3>
            <input type="text" placeholder="Busque ingredientes">
            <div class="lista-basicos">
             <button class="btn-add-basico">Adicionar </button>
            </div>
        </section>
    </div>

</body>
</html>