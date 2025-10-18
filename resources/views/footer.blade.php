<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Remenu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome (ícones) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="css/footer.css">
</head>
<body>

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

  <!-- Bootstrap JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
