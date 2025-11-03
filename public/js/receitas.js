  document.getElementById('searchBtn').addEventListener('click', searchRecipes);

    async function searchRecipes() {
      const query = document.getElementById('searchInput').value.trim();
      if (!query) return alert("Digite algo para pesquisar!");

      try {
        const response = await fetch('/api/search-recipes', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ query })
        });

        const data = await response.json();

        if (data.error) {
          alert("Erro: " + data.error);
          return;
        }

        renderRecipes(data.recipes || []);

      } catch (err) {
        console.error(err);
        alert("Erro ao buscar receitas.");
      }
    }

    function renderRecipes(recipes) {
      const container = document.getElementById('recipesContainer');
      container.innerHTML = '';

      recipes.forEach(recipe => {
        const card = document.createElement('div');
        card.className = 'recipe-card';

        const imageUrl = recipe.photo_url || 'https://via.placeholder.com/300x200?text=Sem+Imagem';

        card.innerHTML = `
          <img src="${imageUrl}" alt="${recipe.name}" />
          <div class="content">
            <h3>${recipe.name}</h3>
            <p>${recipe.description || 'Receita deliciosa e saudável!'}</p>
          </div>
        `;

        container.appendChild(card);
      });
    }