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

    <!-- BANNER -->
  <section class="geladeira-banner"></section>


<!-- TÍTULO -->
<section class="geladeira-title">
<h1>Minha Geladeira</h1>
<p>Gerencie seus ingredientes e evite desperdícios.</p>
</div>


<!-- CONTEÚDO PRINCIPAL -->
<section class="conteudo container">
<div class="row g-4">


<!-- ADICIONAR INGREDIENTE -->
<div class="col-md-4">
<div class="card add">
<h3 class="mb-3"><i class="bi bi-plus-circle"></i> Adicionar Ingrediente</h3>


<label for="buscar-ingrediente">Nome do Ingrediente</label>
<div class="position-relative mb-2">
<input type="text" id="buscar-ingrediente" class="form-control" placeholder="Busque um ingrediente... (autocomplete)">
<div id="autocomplete" class="autocomplete-box"></div>
</div>


<label for="quantidade">Quantidade (Opcional)</label>
<input type="number" id="quantidade" class="form-control mb-2" placeholder="Ex: 2">


<label for="validade">Validade</label>
<input type="date" id="validade" class="form-control mb-2">


<button id="adicionar" class="btn btn-primary w-100 mt-2">Adicionar</button>
</div>


<!-- INGREDIENTES BÁSICOS -->
<div class="card basicos mt-3">
<h3 class="mb-3">Ingredientes Básicos</h3>
<input type="text" id="buscarBasicos" class="form-control" placeholder="Buscar ingredientes...">
<div class="lista-basicos mt-3" id="lista-basicos">
<!-- botões populados pelo JS -->
</div>
<button class="btn btn-add-basico w-100 mt-3">Adicionar selecionado</button>
</div>


</div>


<!-- MEUS INGREDIENTES (agrupados por categoria) -->
<div class="col-md-5">
<div class="card meus-ingredientes">
<h3 class="mb-3"><i class="bi bi-box-seam"></i> Meus Ingredientes</h3>


<div id="listaIngredientes">
<!-- Renderização das categorias e itens pelo JS -->
</div>
</div>
</div>


<!-- ESPAÇO EXTRA / INFORMAÇÕES -->
<div class="col-md-3">
<div class="card">
<h3 class="mb-3">Dicas</h3>
<p>Mantenha sua geladeira organizada. Toque em um ingrediente para editar quantidade/validade.</p>
</div>
</div>


</div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("buscar-ingrediente");
    const autocompleteBox = document.getElementById("autocomplete");
    const listaCategorias = document.getElementById("lista-geladeira");

    // ----------------------------
    // Autocomplete de ingredientes
    // ----------------------------
    searchInput.addEventListener("input", async () => {
        const query = searchInput.value.trim();
        if (query.length < 1) {
            autocompleteBox.innerHTML = "";
            return;
        }

        const res = await fetch(`/api/ingredientes/search?query=${query}`, {
            credentials: "include"
        });

        const ingredientes = await res.json();
        autocompleteBox.innerHTML = "";

        ingredientes.forEach(ing => {
            const item = document.createElement("div");
            item.classList.add("autocomplete-item");
            item.textContent = ing.nome;
            item.dataset.id = ing.id;

            item.addEventListener("click", () => {
                searchInput.value = ing.nome;
                searchInput.dataset.id = ing.id;
                autocompleteBox.innerHTML = "";
            });

            autocompleteBox.appendChild(item);
        });
    });

    // ---------------------
    // Carregar a geladeira
    // ---------------------
    async function carregarGeladeira() {
        const res = await fetch("/api/geladeira", { credentials: "include" });
        const dados = await res.json();

        listaCategorias.innerHTML = "";

        dados.forEach(item => {
            const div = document.createElement("div");
            div.classList.add("ingrediente-item");
            div.innerHTML = `
                <strong>${item.ingrediente.nome}</strong>
                <p>Quantidade: <span>${item.quantidade}</span></p>
                <p>Validade: <span>${item.validade ?? "—"}</span></p>

                <button class="btn-editar" data-id="${item.id}">Editar</button>
                <button class="btn-excluir" data-id="${item.id}">Excluir</button>
            `;
            listaCategorias.appendChild(div);
        });

        adicionarEventos();
    }

    carregarGeladeira();

    // -------------------------
    // Adicionar ingrediente
    // -------------------------
    document.getElementById("adicionar").addEventListener("click", async () => {
        const ingredienteId = searchInput.dataset.id;
        const quantidade = document.getElementById("quantidade").value;
        const validade = document.getElementById("validade").value;

        if (!ingredienteId) {
            alert("Escolha um ingrediente da lista!");
            return;
        }

        const res = await fetch("/api/geladeira", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            credentials: "include",
            body: JSON.stringify({
                ingrediente_id: ingredienteId,
                quantidade,
                validade
            })
        });

        if (res.ok) {
            searchInput.value = "";
            searchInput.dataset.id = "";
            document.getElementById("quantidade").value = "";
            document.getElementById("validade").value = "";
            carregarGeladeira();
        }
    });

    // -------------------------
    // Editar ou excluir
    // -------------------------
    function adicionarEventos() {
        // Excluir
        document.querySelectorAll(".btn-excluir").forEach(btn => {
            btn.addEventListener("click", async () => {
                const id = btn.dataset.id;
                await fetch(`/api/geladeira/${id}`, {
                    method: "DELETE",
                    credentials: "include"
                });
                carregarGeladeira();
            });
        });

        // Editar
        document.querySelectorAll(".btn-editar").forEach(btn => {
            btn.addEventListener("click", async () => {
                const id = btn.dataset.id;
                const novaQuantidade = prompt("Nova quantidade:");
                const novaValidade = prompt("Nova validade (YYYY-MM-DD):");

                await fetch(`/api/geladeira/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    credentials: "include",
                    body: JSON.stringify({
                        quantidade: novaQuantidade,
                        validade: novaValidade
                    })
                });

                carregarGeladeira();
            });
        });
    }
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>