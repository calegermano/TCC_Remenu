<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receitas</title>
    <style>
        body { font-family: sans-serif; max-width: 1000px; margin: 30px auto; }
        input { padding: 10px; width: 300px; font-size: 16px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { border: 1px solid #eee; border-radius: 8px; padding: 12px; }
        .card img { width: 100%; height: 150px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <input type="text" id="q" placeholder="Busque uma receita (ex: pasta, cake)" value="pasta">
    <button onclick="search()">Buscar</button>

    <div class="grid" id="results"></div>

    <script>
        async function search() {
            const q = document.getElementById('q').value;
            const res = await fetch(`/api/recipes/search?q=${encodeURIComponent(q)}`);
            const data = await res.json();

            const html = data.recipes.map(r => `
                <div class="card">
                    ${r.image ? `<img src="${r.image}" alt="${r.name}">` : ''}
                    <h3>${r.name}</h3>
                    <p>${r.description.substring(0, 100)}...</p>
                    <a href="${r.url}" target="_blank">Ver receita</a>
                </div>
            `).join('');

            document.getElementById('results').innerHTML = html || '<p>Nenhuma receita encontrada.</p>';
        }

        // Busca ao carregar a página
        search();
    </script>
</body>
</html>