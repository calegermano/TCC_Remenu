<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Geladeira</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <style>

        body {
            background-color: #fff;
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
            margin-top: 35px;
            font-weight: bolder;
        }

        .geladeira-title p {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            padding-bottom: 20px
        }

        .card {
            border-radius: 14px;
            padding: 20px;
            background: #f0f0f0;
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
            border: 1px solid #f2f2f2;
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
    background-color: #D9682B !important;
    border-color: #D9682B !important;
    color: white !important;
}

#adicionar:hover {
    background-color: #ac5323ff !important;
    border-color: #ac5323ff !important;
}

/* título "ingredientes básicos" */
.card.basicos h3 {
    color: #D96828;
    font-weight: 600
}

.btn-add-basico {
    background-color: #D9682B !important;
    border-color: #D9682B !important;
    color: white !important;
}

.btn-add-basico:hover {
    background-color: #ac5323ff !important;
    border-color: #ac5323ff !important;
}

.form-control {
    background-color: #d9d9d9;
    border: 1px solid #d9d9d9;
    border-radius: 8px;
}

.form-control:focus {
    background-color: #d9d9d9;
    border-color: #d9d9d9;
}

label {
    color: #666666;
    font-weight: 600;
    font-size: 15px;
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

                    <label for="quantidade">Quantidade (opcional)</label>
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

    // Pega o crachá de segurança (Token)
    function getCsrfToken() {
        const tokenTag = document.querySelector('meta[name="csrf-token"]');
        return tokenTag ? tokenTag.content : "";
    }

    /* --- 1. BUSCAR DADOS E MOSTRAR NA TELA --- */
    async function carregarGeladeira() {
        try {
            // O Cliente pede os dados para o Garçom
            const res = await fetch("/api/geladeira"); 
            const dadosAgrupados = await res.json();

            listaCategorias.innerHTML = "";

            // Se a geladeira estiver vazia
            if (!dadosAgrupados || Object.keys(dadosAgrupados).length === 0) {
                listaCategorias.innerHTML = '<p class="text-muted text-center mt-4">Sua geladeira está vazia.</p>';
                return;
            }

            // O Controller mandou os dados separados por categoria (Frutas, Legumes...)
            // Vamos percorrer cada categoria
            for (const [categoriaNome, itens] of Object.entries(dadosAgrupados)) {
                
                // Cria o título da categoria
                const titulo = document.createElement("h5");
                titulo.style.color = "#D9682B";
                titulo.style.marginTop = "20px";
                titulo.textContent = categoriaNome;
                listaCategorias.appendChild(titulo);

                // Cria os itens dessa categoria
                itens.forEach(item => {
                    const div = document.createElement("div");
                    div.className = "ingrediente-item p-3 mb-2 border rounded";
                    div.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <strong>${item.ingrediente}</strong>
                            <span>Qtd: ${item.quantidade}</span>
                        </div>
                        <small>Validade: ${item.validade ? new Date(item.validade).toLocaleDateString('pt-BR') : '—'}</small>
                        <div class="mt-2 text-end">
                            <button class="btn btn-sm btn-success btn-editar" data-id="${item.id}">Editar</button>
                            <button class="btn btn-sm btn-danger btn-excluir" data-id="${item.id}">Excluir</button>
                        </div>
                    `;
                    listaCategorias.appendChild(div);
                });
            }

            // Ativa os botões de editar e excluir que acabamos de criar
            adicionarEventosBotoes();

        } catch (erro) {
            console.error("Erro ao carregar:", erro);
        }
    }

    /* --- 2. ADICIONAR NOVO INGREDIENTE --- */
    document.getElementById("adicionar").addEventListener("click", async () => {
        const nome = searchInput.value;
        const qtd = document.getElementById("quantidade").value;
        const val = document.getElementById("validade").value;

        if (!nome) return alert("Digite o nome do ingrediente!");

        const dados = { ingrediente: nome, quantidade: qtd, validade: val };

        await fetch("/api/geladeira", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken() // Mostra o crachá de segurança
            },
            body: JSON.stringify(dados)
        });

        // Limpa os campos e recarrega a lista
        searchInput.value = "";
        document.getElementById("quantidade").value = "";
        document.getElementById("validade").value = "";
        carregarGeladeira();
    });

    /* --- 3. AUTOCOMPLETE (Sugestão de nomes) --- */
    searchInput.addEventListener("input", async () => {
        const texto = searchInput.value;
        if (texto.length < 1) { autocompleteBox.innerHTML = ""; return; }

        const res = await fetch(`/api/ingredientes/search?query=${texto}`);
        const lista = await res.json();

        autocompleteBox.innerHTML = "";
        lista.forEach(ing => {
            const div = document.createElement("div");
            div.className = "autocomplete-item p-2 border-bottom";
            div.style.cursor = "pointer";
            div.textContent = ing.nome;
            div.onclick = () => {
                searchInput.value = ing.nome;
                autocompleteBox.innerHTML = "";
            };
            autocompleteBox.appendChild(div);
        });
    });

    /* --- 4. FUNÇÕES DE EDITAR E EXCLUIR --- */
    function adicionarEventosBotoes() {
        // Botão Excluir
        document.querySelectorAll(".btn-excluir").forEach(btn => {
            btn.onclick = async () => {
                if(!confirm("Remover este item?")) return;
                const id = btn.dataset.id;
                await fetch(`/api/geladeira/${id}`, {
                    method: "DELETE",
                    headers: { "X-CSRF-TOKEN": getCsrfToken() }
                });
                carregarGeladeira();
            };
        });

        // Botão Editar
        document.querySelectorAll(".btn-editar").forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.id;
                const novaQtd = prompt("Nova quantidade:");
                if(novaQtd) {
                    await fetch(`/api/geladeira/${id}`, {
                        method: "PUT",
                        headers: { 
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": getCsrfToken()
                        },
                        body: JSON.stringify({ quantidade: novaQtd })
                    });
                    carregarGeladeira();
                }
            };
        });
    }

    // Carrega a lista assim que a página abre
    carregarGeladeira();
});

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

