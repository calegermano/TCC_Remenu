<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Remenu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome (ícones) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="css/footer.css">
</head>
<body>

  <!-- Footer -->
  <footer>
    <div class="container">

      <div class="row text-start a">
        <!-- Logo e Descrição -->
        <div class="col-md-4 mb-4">
          <div class="footer-logo mb-2">
            <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2">
          </div>
          <p>Plataforma de receitas saudáveis<br>com foco em reduzir desperdício alimentar</p>
        </div>

        <!-- Navegação (centralizada e responsiva) -->
        <div class="col-md-3 mb-3 text-center">
          <h5 class="footer-title">Navegação</h5>
          <div class="footer-nav d-flex flex-wrap justify-content-center gap-3">
            <a href="#" class="nav-item text-decoration-none text-secondary">
              <i class="fas fa-home"></i> Home
            </a>
            <a href="#" class="nav-item text-decoration-none text-secondary">
              <i class="fas fa-calendar-alt"></i> Planejamento
            </a>
            <a href="#" class="nav-item text-decoration-none text-secondary">
              <i class="fas fa-snowflake"></i> Geladeira
            </a>
            <a href="#" class="nav-item text-decoration-none text-secondary">
              <i class="fas fa-utensils"></i> Receitas
            </a>
            <a href="#" class="nav-item text-decoration-none text-secondary">
              <i class="fas fa-heart"></i> Favoritos
            </a>
            
          </div>
        </div>

        <!-- Contato e Suporte -->
        <div class="col-md-4 mb-4">
          <h5 class="footer-title">Contato & Suporte</h5>
          <ul class="list-unstyled">
            <li><i class="fas fa-envelope"></i> contato@remenu.com.br</li>
            <li><i class="fas fa-phone"></i> (11) 9999-9999</li>
          </ul>
        </div>
      </div>

      <hr>

      <!-- Rodapé inferior -->
      <div class="row align-items-center py-3">
  <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
    <p class="mb-0">© 2025 REMENU. Todos os direitos reservados.</p>
  </div>
  <div class="col-md-6 text-center text-md-end">
    <div class="footer-links">
      <a href="#" class="me-3">Privacidade</a>
      <a href="#" class="me-3">Termos de Uso</a>
      <a href="#" class="me-3">FAQ</a>
      <a href="#">Suporte</a>
    </div>
  </div>
</div>
    </div>
  </footer>

  <!-- Bootstrap JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
