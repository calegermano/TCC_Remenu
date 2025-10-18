<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REMENU - Receitas Saudáveis</title>
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/home2.css">
</head>
<body>

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
      <a href="#" class="btn btn-banner mt-3">
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
      <a href="#" class="btn btn-planejar mt-3">Planeje suas refeições →</a>
    </div>

    <div class="imagens">
      <img src="../assets/img/card1.jpg" class="img-principal" alt="Tigela de Açaí e frutas">
      <img src="../assets/img/card1.jpg" class="img-secundaria" alt="Salada com atum e ovos">
      <img src="../assets/img/card1.jpg" class="img-secundaria2" alt="Torrada com abacate e ovos">
    </div>
  </div>
</section>


<section class="receitas-destaque py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h3 class="receitas-titulo fw-bold mx-auto">Receitas em destaque</h3>
      
      <a href="#" class="btn btn-veja-mais btn-sm">Veja mais</a>
    </div>

    <div class="row g-4">
      
      <div class="col-12 col-md-4">
        <div class="card h-100 receita-card">
          <img src="../assets/img/detox.jpg" class="card-img-top card-img-receita" alt="Smoothie Verde Detox">
          <div class="card-body text-center">
            <h5 class="card-title receita-card-title">Smoothie Verde Detox</h5>
            <p class="card-text receita-card-text">Bebida refrescante e nutritiva para começar o dia com energia.</p>
            
            <div class="d-flex justify-content-around card-footer-details mt-3">
              <span class="detalhe-item">
                <i class="fas fa-clock"></i> 10 min
              </span>
              <span class="detalhe-item">
                <i class="fas fa-users"></i> 4 pessoas
              </span>
              <span class="detalhe-item favorito-icon">
                <i class="far fa-heart"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-12 col-md-4">
        <div class="card h-100 receita-card">
          <img src="../assets/img/sopa.jpg" class="card-img-top card-img-receita" alt="Sopa de Legumes">
          <div class="card-body text-center">
            <h5 class="card-title receita-card-title">Sopa de Legumes</h5>
            <p class="card-text receita-card-text">Uma sopa saborosa e nutritiva feita com vegetais que já estão murchando.</p>
            <div class="d-flex justify-content-around card-footer-details mt-3">
              <span class="detalhe-item">
                <i class="fas fa-clock"></i> 10 min
              </span>
              <span class="detalhe-item">
                <i class="fas fa-users"></i> 4 pessoas
              </span>
              <span class="detalhe-item favorito-icon">
                <i class="far fa-heart"></i>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="card h-100 receita-card">
          <img src="../assets/img/frango.jpg" class="card-img-top card-img-receita" alt="Frango com Arroz Integral">
          <div class="card-body text-center">
            <h5 class="card-title receita-card-title">Frango com Arroz Integral</h5>
            <p class="card-text receita-card-text">Prato completo e balanceado, rico em proteínas e carboidratos complexos.</p>
            <div class="d-flex justify-content-around card-footer-details mt-3">
              <span class="detalhe-item">
                <i class="fas fa-clock"></i> 10 min
              </span>
              <span class="detalhe-item">
                <i class="fas fa-users"></i> 4 pessoas
              </span>
              <span class="detalhe-item favorito-icon">
                <i class="far fa-heart"></i>
              </span>
            </div>
          </div>
        </div>
      </div>

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
            <a href="#" class="btn btn-recurso mt-auto">Ver favoritos</a>
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
            <a href="#" class="btn btn-recurso mt-auto">Ver favoritos</a>
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
            <a href="#" class="btn btn-recurso mt-auto">Ver favoritos</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Importa header e footer
    fetch("componentes/header.html").then(r => r.text()).then(d => document.getElementById("header").innerHTML = d);
    fetch("componentes/footer.html").then(r => r.text()).then(d => document.getElementById("footer").innerHTML = d);
  </script>
</body>
</html>
