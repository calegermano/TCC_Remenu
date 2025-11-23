<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geladeira</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <style>

        body {
            background-color: #f9f9f9;
            font-family: 'Poppins', sans-serif;
        }

        .geladeira-banner {
            width: 100%;
            height: 220px;
            background-image: url('../assets/img/geladeira.jpg');
            background-size: cover;
            background-position: center;
        }

        .geladeira-title h1 {
            color: #50D9B0;
            text-align: center;
            margin-top: 30px;
        }

        .geladeira-title p {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
        }

        .card {
            border-radius: 14px;
            padding: 20px;
            background: #fff;
        }

        /* Caixa de autocomplete */
        .autocomplete-box {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 180px;
            overflow-y: auto;
            z-index: 10;
            border-radius: 6px;
        }

        .autocomplete-item {
            padding: 8px;
            cursor: pointer;
        }
        .autocomplete-item:hover {
            background: #e9e9e9;
        }

        /* Itens da geladeira */
        .ingrediente-item {
            padding: 12px;
            border: 1px solid #ececec;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .ingrediente-item strong {
            font-size: 16px;
        }

        .btn-editar, .btn-excluir {
            margin-top: 8px;
            font-size: 13px;
            padding: 4px 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-editar { background: #4cd964; color: white; }
        .btn-excluir { background: #ff6b6b; color: white; }

/* título "add ingrediente" */
.card.add h3 {
    color: #D9682B;
    font-weight: 600
}

/* título "meus ingredientes" */
.card.meus-ingredientes h3 {
    color: #D9682B;
    font-weight: 600
}

/* titulo "dicas"*/
.col-md-3 .card h3 {
    color: #D9682B;
    font-weight: 600;
} 

/* botão "adicionar" */
#adicionar {
    background-color: #50D9B0 !important;
    border-color: #50D9B0 !important;
    color: white !important;
}

#adicionar:hover {
    background-color: #3cbf96 !important;
    border-color: #3cbf96 !important;
}

/* título "ingredientes básicos" */
.card.basicos h3 {
    color: #D96828;
    font-weight: 600
}

.btn-add-basico {
    background-color: #50D9B0 !important;
    border-color: #50D9B0 !important;
    color: white !important;
}

.btn-add-basico:hover {
    background-color: #3cbf96 !important;
    border-color: #3cbf96 !important;
}
    </style>
</head>

<body>

    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-item-center fw-semibold" href="resources/views/home.blade.php">
                <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="40" height="40" class="me-2">
            </a>
            <span class="titulo">Remenu</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="menuNav">
                <ul class ="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="home2">Início</a></li>
                    <li class="nav-item"><a class="nav-link active" href="receitas">Receitas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="planejamento">Planejamento</a></li>
                    <li class="nav-item"><a class="nav-link active" href="favoritos">Favoritos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="geladeira">Minha Geladeira</a></li>
                </ul>
            </div>

            <a href="#" class="profile-link d-none d-lg-block"><i class="bi bi-person-fill"></i></a>
        </div>            
    </nav>

    <!-- Banner -->
    <section class="geladeira-banner"></section>

    <!-- Título -->
    <section class="geladeira-title">
        <h1>Minha Geladeira</h1>
        <p>Gerencie seus ingredientes e evite desperdícios.</p>
    </section>

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

                    <label for="quantidade">Quantidade</label>
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
                    </div>

                    <button class="btn btn-add-basico w-100 mt-3">Adicionar Selecionado</button>
                </div>
            </div>

            <!-- MEUS INGREDIENTES -->
            <div class="col-md-5">
                <div class="card meus-ingredientes">
                    <h3 class="mb-3"><i class="bi bi-box-seam"></i> Meus Ingredientes</h3>

                    <div id="listaIngredientes">    <p id="aviso-vazio" class="text-muted" style="text-align:center; padding:15px;">
        Sua geladeira está vazia.<br>Adicione ingredientes para começar! </p> </div>
                </div>
            </div>

            <!-- DICAS -->
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
    const listaCategorias = document.getElementById("listaIngredientes");

    /* ---------------- FUNÇÃO DO PLACEHOLDER ---------------- */
    function atualizarPlaceholder() {
        let placeholder = document.getElementById("placeholder-ingredientes");

        if (!placeholder) {
            placeholder = document.createElement("p");
            placeholder.id = "placeholder-ingredientes";
            placeholder.textContent = "Nenhum ingrediente adicionado ainda.";
            placeholder.style.color = "#888";
            placeholder.style.textAlign = "center";
            placeholder.style.padding = "15px 0";
            placeholder.style.fontSize = "14px";
        }

        if (listaCategorias.children.length === 0) {
            listaCategorias.appendChild(placeholder);
        } else {
            if (placeholder.parentNode) placeholder.remove();
        }
    }

    /* ---------------- AUTOCOMPLETE ---------------- */
    searchInput.addEventListener("input", async () => {
        const query = searchInput.value.trim();
        if (query.length < 1) {
            autocompleteBox.innerHTML = "";
            return;
        }

        const res = await fetch(`/api/ingredientes/search?query=${query}`, { credentials: "include" });
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

    /* ---------------- CARREGAR GELADEIRA ---------------- */
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

        atualizarPlaceholder();
        adicionarEventos();
    }

    carregarGeladeira();

    /* ---------------- ADICIONAR ---------------- */
    document.getElementById("adicionar").addEventListener("click", async () => {
        const ingredienteId = searchInput.dataset.id;
        const quantidade = document.getElementById("quantidade").value;
        const validade = document.getElementById("validade").value;

        if (!ingredienteId) {
            alert("Escolha um ingrediente da lista!");
            return;
        }

        await fetch("/api/geladeira", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            credentials: "include",
            body: JSON.stringify({ ingrediente_id: ingredienteId, quantidade, validade })
        });

        searchInput.value = "";
        searchInput.dataset.id = "";
        document.getElementById("quantidade").value = "";
        document.getElementById("validade").value = "";

        carregarGeladeira();
    });

    /* ---------------- EDITAR / EXCLUIR ---------------- */
    function adicionarEventos() {

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

