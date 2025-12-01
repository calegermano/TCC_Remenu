<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Geladeira - Remenu</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <style>
        body { background-color: #fff; font-family: 'Poppins', sans-serif; }
        
        .geladeira-banner {
            width: 100%; height: 220px;
            background-image: url('../assets/img/geladeira.jpg');
            background-size: cover; background-position: center;
        }

        .geladeira-title h1 { color: #50D9B0; text-align: center; margin-top: 35px; font-weight: bolder; }
        .geladeira-title p { text-align: center; color: #555; margin-bottom: 30px; padding-bottom: 20px; }

        .card { border-radius: 14px; padding: 20px; background: #f8f9fa; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { font-size: 1.25rem; margin-bottom: 1rem; color: #D9682B; font-weight: 600; }

        .autocomplete-box {
            position: absolute; background: white; border: 1px solid #ccc;
            width: 100%; max-height: 180px; overflow-y: auto; z-index: 100; border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .autocomplete-item { padding: 10px; cursor: pointer; border-bottom: 1px solid #eee; }
        .autocomplete-item:hover { background: #f0f0f0; }

        .ingrediente-item { background: white; border-radius: 10px; border-left: 5px solid #50D9B0; transition: transform 0.2s; }
        .ingrediente-item:hover { transform: translateY(-2px); box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .ingrediente-item strong { color: #333; }
        
        .btn-primary-custom { background-color: #D9682B; border-color: #D9682B; color: white; }
        .btn-primary-custom:hover { background-color: #bf5b26; border-color: #bf5b26; color: white; }
        
        .btn-editar { background: #4cd964; color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; }
        .btn-excluir { background: #ff6b6b; color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; }

        .lista-basicos { max-height: 250px; overflow-y: auto; background: white; padding: 10px; border-radius: 8px; border: 1px solid #eee; }
        .form-check-label { font-size: 0.9rem; color: #555; cursor: pointer; }
        
        .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(217, 104, 43, 0.25); border-color: #D9682B; }
        label { color: #666; font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; }

        /* Estilo do Modal de Edição */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 9999;
            align-items: center; justify-content: center;
        }
        .modal-content-custom {
            background: white; padding: 25px; border-radius: 12px; width: 90%; max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-item-center fw-semibold" href="home2">
                <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2">
            </a>
            <span class="titulo">Remenu</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="menuNav">
                <ul class ="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home2">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="receitas">Receitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="planejamento">Planejamento</a></li>
                    <li class="nav-item"><a class="nav-link" href="favoritos">Favoritos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="geladeira">Minha Geladeira</a></li>
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

    <section class="geladeira-banner"></section>

    <section class="geladeira-title">
        <h1>Minha Geladeira</h1>
        <p>Gerencie seus ingredientes e evite desperdícios.</p>
    </section>

    <section class="conteudo container mb-5">
        <div class="row g-4">

            <!-- COLUNA 1: ADICIONAR + BÁSICOS -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <h3><i class="bi bi-plus-circle"></i> Adicionar Item</h3>
                    <div class="mb-3 position-relative">
                        <label for="buscar-ingrediente">Ingrediente</label>
                        <input type="text" id="buscar-ingrediente" class="form-control" placeholder="Digite para buscar..." autocomplete="off">
                        <div id="autocomplete" class="autocomplete-box"></div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="quantidade">Qtd (aprox.)</label>
                            <input type="number" id="quantidade" class="form-control" placeholder="Ex: 1" min="1">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="validade">Validade</label>
                            <input type="date" id="validade" class="form-control">
                        </div>
                    </div>
                    <button id="adicionar" class="btn btn-primary-custom w-100">Adicionar à Geladeira</button>
                </div>

                <div class="card">
                    <h3><i class="bi bi-basket"></i> Itens Básicos</h3>
                    <p class="text-muted small">Pesquise e marque os itens para adicionar rápido.</p>
                    
                    <input type="text" id="buscarBasicos" class="form-control mb-2 form-control-sm" placeholder="Filtrar lista...">

                    <div class="lista-basicos" id="lista-basicos-container">
                        <!-- Checkboxes gerados via JS -->
                    </div>

                    <button id="btn-add-basicos" class="btn btn-primary-custom w-100 mt-3">Adicionar Selecionados</button>
                </div>
            </div>

            <!-- COLUNA 2: MEUS INGREDIENTES -->
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3><i class="bi bi-box-seam"></i> Na Geladeira</h3>
                        <span class="badge bg-secondary" id="total-itens">0 itens</span>
                    </div>

                    <div id="listaIngredientes" style="max-height: 800px; overflow-y: auto;">    
                        <div class="text-center py-5">
                            <div class="spinner-border text-secondary" role="status"></div>
                            <p class="mt-2 text-muted">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUNA 3: DICAS -->
            <div class="col-md-3">
                <div class="card bg-white border-warning mb-3">
                    <h3 class="text-warning"><i class="bi bi-lightbulb"></i> Dicas</h3>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2">📅 <strong>Validade:</strong> Sempre verifique a data de vencimento dos laticínios.</li>
                        <li class="mb-2">❄️ <strong>Congelador:</strong> Carnes próximas do vencimento podem ser congeladas.</li>
                        <li>🥗 <strong>Planejamento:</strong> Use a aba "Planejamento" para usar o que está prestes a vencer.</li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <!-- MODAL DE EDIÇÃO -->
    <div id="modalEditarItem" class="modal-overlay">
        <div class="modal-content-custom">
            <h4 class="mb-3">Editar Ingrediente</h4>
            <input type="hidden" id="edit-id">
            
            <div class="mb-3">
                <label for="edit-qtd">Quantidade</label>
                <input type="number" id="edit-qtd" class="form-control" min="1">
            </div>
            
            <div class="mb-3">
                <label for="edit-validade">Validade</label>
                <input type="date" id="edit-validade" class="form-control">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-secondary" onclick="fecharModalEdicao()">Cancelar</button>
                <button class="btn btn-primary-custom" onclick="salvarEdicao()">Salvar</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("buscar-ingrediente");
        const autocompleteBox = document.getElementById("autocomplete");
        const listaCategorias = document.getElementById("listaIngredientes");
        const totalItensBadge = document.getElementById("total-itens");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Lista de Ingredientes Básicos
        const ingredientesBasicos = [
            "Arroz branco", "Feijão carioca", "Feijão preto", "Macarrão", 
            "Óleo de soja", "Azeite de oliva", "Sal", "Açúcar", "Café", 
            "Leite integral", "Ovos", "Manteiga", "Farinha de trigo", 
            "Cebola", "Alho", "Tomate", "Batata inglesa", "Cenoura", 
            "Alface", "Limão", "Banana prata", "Maçã", "Pão francês"
        ];

        /* --- 1. CARREGAR GELADEIRA --- */
        async function carregarGeladeira() {
            try {
                const res = await fetch("/api/geladeira"); 
                if (!res.ok) throw new Error(`Erro API: ${res.status}`);

                const dadosAgrupados = await res.json();
                listaCategorias.innerHTML = "";
                let total = 0;

                if (!dadosAgrupados || (Array.isArray(dadosAgrupados) && dadosAgrupados.length === 0) || Object.keys(dadosAgrupados).length === 0) {
                    listaCategorias.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-basket2" style="font-size: 3rem; color: #eee;"></i>
                            <p class="text-muted mt-3">Sua geladeira está vazia.</p>
                        </div>`;
                    totalItensBadge.textContent = "0 itens";
                    return;
                }

                for (const [categoriaNome, itens] of Object.entries(dadosAgrupados)) {
                    const titulo = document.createElement("h6");
                    titulo.className = "text-uppercase text-muted mt-3 mb-2 small fw-bold";
                    titulo.style.letterSpacing = "1px";
                    titulo.textContent = categoriaNome;
                    listaCategorias.appendChild(titulo);

                    itens.forEach(item => {
                        total++;
                        const dataValidade = item.validade ? new Date(item.validade) : null;
                        
                        // Ajuste de fuso horário simples para exibição
                        let dataFormatada = '—';
                        if(dataValidade) {
                            // Adiciona fuso para não cair no dia anterior
                            const userTimezoneOffset = dataValidade.getTimezoneOffset() * 60000;
                            const adjustedDate = new Date(dataValidade.getTime() + userTimezoneOffset);
                            dataFormatada = adjustedDate.toLocaleDateString('pt-BR');
                        }
                        
                        let validadeClass = "text-muted";
                        let validadeIcon = "";
                        const hoje = new Date();
                        hoje.setHours(0,0,0,0);

                        if (dataValidade && dataValidade < hoje) {
                            validadeClass = "text-danger fw-bold";
                            validadeIcon = '<i class="bi bi-exclamation-triangle-fill"></i>';
                        }

                        const div = document.createElement("div");
                        div.className = "ingrediente-item p-3 mb-2 shadow-sm border";
                        div.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong style="font-size: 1.05rem;">${item.ingrediente}</strong>
                                    <div class="small ${validadeClass}">
                                        <i class="bi bi-calendar"></i> ${dataFormatada} ${validadeIcon}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-dark border mb-2 d-block">Qtd: ${item.quantidade || 1}</span>
                                    
                                    <!-- Botão Editar passando parâmetros -->
                                    <button class="btn-editar" 
                                        onclick="abrirModalEdicao('${item.id}', '${item.quantidade}', '${item.validade || ''}')" 
                                        title="Editar"><i class="bi bi-pencil"></i></button>
                                        
                                    <button class="btn-excluir" data-id="${item.id}" title="Excluir"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        `;
                        listaCategorias.appendChild(div);
                    });
                }
                totalItensBadge.textContent = `${total} itens`;
                adicionarEventosExcluir();

            } catch (erro) {
                console.error("Erro:", erro);
                listaCategorias.innerHTML = '<p class="text-danger text-center">Erro ao carregar itens.</p>';
            }
        }

        /* --- 2. ADICIONAR MANUAL --- */
        document.getElementById("adicionar").addEventListener("click", async () => {
            const nome = searchInput.value;
            let qtd = document.getElementById("quantidade").value; // Pegamos o valor bruto
            const val = document.getElementById("validade").value;

            if (!nome) return alert("Digite o nome do ingrediente!");
            
            // VALIDACAO NOVA: Se não tiver qtd ou for menor que 1, força ser 1 ou avisa
            if (!qtd || qtd < 1) {
                alert("A quantidade não pode ser negativa ou zero.");
                return; // Para tudo e não envia
            }

            // Envia garantindo que é número positivo
            enviarIngrediente(nome, qtd, val).then(() => {
                searchInput.value = "";
                document.getElementById("quantidade").value = "";
                document.getElementById("validade").value = "";
            });
        });

        async function enviarIngrediente(nome, qtd, validade) {
            try {
                const res = await fetch("/api/geladeira", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ ingrediente: nome, quantidade: qtd, validade: validade })
                });

                if (!res.ok) {
                    const erro = await res.json();
                    alert(erro.erro || "Erro ao adicionar.");
                    return;
                }
                carregarGeladeira();
            } catch (e) { console.error(e); }
        }

        /* --- 3. AUTOCOMPLETE --- */
        searchInput.addEventListener("input", async () => {
            const texto = searchInput.value;
            if (texto.length < 2) { autocompleteBox.innerHTML = ""; return; }
            try {
                const res = await fetch(`/api/ingredientes/search?query=${texto}`);
                const lista = await res.json();
                autocompleteBox.innerHTML = "";
                lista.forEach(ing => {
                    const div = document.createElement("div");
                    div.className = "autocomplete-item";
                    div.textContent = ing.nome;
                    div.onclick = () => {
                        searchInput.value = ing.nome;
                        autocompleteBox.innerHTML = "";
                    };
                    autocompleteBox.appendChild(div);
                });
            } catch(e) {}
        });
        document.addEventListener("click", (e) => {
            if (e.target !== searchInput) autocompleteBox.innerHTML = "";
        });

        /* --- 4. LISTA DE BÁSICOS (CHECKBOXES) --- */
        const containerBasicos = document.getElementById("lista-basicos-container");
        const filtroBasicos = document.getElementById("buscarBasicos");

        function renderizarBasicos(filtro = "") {
            containerBasicos.innerHTML = "";
            // CORREÇÃO DA PESQUISA: Usar toLowerCase() para ignorar maiúsculas/minúsculas
            const filtrados = ingredientesBasicos.filter(i => i.toLowerCase().includes(filtro.toLowerCase()));

            if(filtrados.length === 0) {
                containerBasicos.innerHTML = "<small class='text-muted p-2'>Nenhum item encontrado.</small>";
                return;
            }

            filtrados.forEach(nome => {
                const div = document.createElement("div");
                div.className = "form-check mb-2";
                div.innerHTML = `
                    <input class="form-check-input check-basico" type="checkbox" value="${nome}" id="check-${nome}">
                    <label class="form-check-label" for="check-${nome}">${nome}</label>
                `;
                containerBasicos.appendChild(div);
            });
        }

        filtroBasicos.addEventListener("input", (e) => renderizarBasicos(e.target.value));

        document.getElementById("btn-add-basicos").addEventListener("click", async () => {
            const checks = document.querySelectorAll(".check-basico:checked");
            if (checks.length === 0) return alert("Selecione pelo menos um item.");

            for (const chk of checks) {
                await fetch("/api/geladeira", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ ingrediente: chk.value, quantidade: 1, validade: null })
                });
                chk.checked = false; 
            }
            alert(`Itens adicionados!`);
            carregarGeladeira();
        });

        /* --- 5. EXCLUIR --- */
        function adicionarEventosExcluir() {
            document.querySelectorAll(".btn-excluir").forEach(btn => {
                btn.onclick = async () => {
                    if(!confirm("Remover este item?")) return;
                    await fetch(`/api/geladeira/${btn.dataset.id}`, {
                        method: "DELETE",
                        headers: { "X-CSRF-TOKEN": csrfToken }
                    });
                    carregarGeladeira();
                };
            });
        }

        // --- 6. FUNÇÕES DE EDIÇÃO (MODAL) ---
        // Funções globais para serem chamadas pelo onclick no HTML
        window.abrirModalEdicao = function(id, qtd, validade) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-qtd').value = qtd;
            document.getElementById('edit-validade').value = validade;
            document.getElementById('modalEditarItem').style.display = 'flex';
        };

        window.fecharModalEdicao = function() {
            document.getElementById('modalEditarItem').style.display = 'none';
        };

        /* --- FUNÇÃO DE SALVAR EDIÇÃO --- */
        window.salvarEdicao = async function() {
            const id = document.getElementById('edit-id').value;
            const qtd = document.getElementById('edit-qtd').value;
            const val = document.getElementById('edit-validade').value;

            // VALIDACAO NOVA
            if (qtd < 1) {
                alert("A quantidade deve ser pelo menos 1.");
                return;
            }

            try {
                const res = await fetch(`/api/geladeira/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ quantidade: qtd, validade: val })
                });
                if(res.ok) {
                    fecharModalEdicao();
                    carregarGeladeira();
                } else {
                    alert("Erro ao salvar edição.");
                }
            } catch(e) { console.error(e); }
        };


        // Redefinindo o botão salvar do modal para não usar window.salvarEdicao, mas sim EventListener
        window.salvarEdicao = async function() {
            const id = document.getElementById('edit-id').value;
            const qtd = document.getElementById('edit-qtd').value;
            const val = document.getElementById('edit-validade').value;

            try {
                const res = await fetch(`/api/geladeira/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ quantidade: qtd, validade: val })
                });
                if(res.ok) {
                    fecharModalEdicao();
                    carregarGeladeira(); // Agora funciona pois está no escopo
                }
            } catch(e) { console.error(e); }
        };

        // Inicializar
        renderizarBasicos();
        carregarGeladeira();
    });
    </script>
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
</body>
</html>