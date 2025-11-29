// Verificação e limpeza de gráficos existentes
function cleanExistingCharts() {
    const chartIds = ['myAreaChart', 'myPieChart', 'myBarChart'];
    chartIds.forEach(canvasId => {
        const existingChart = Chart.getChart(canvasId);
        if (existingChart) {
            console.log('Destruindo gráfico existente:', canvasId);
            existingChart.destroy();
        }
    });
}

// Gráficos do Dashboard Remenu - Chart.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando gráficos do dashboard...');
    
    // Verificar se Chart.js está carregado
    if (typeof Chart === 'undefined') {
        console.error('Chart.js não está carregado!');
        return;
    }

    // Limpar gráficos existentes (caso demos tenham sido carregados)
    cleanExistingCharts();

    // Aguardar um pouco para garantir que o DOM esteja pronto
    setTimeout(() => {
        initializeChartsWithRealData();
    }, 100);
});

// Gráficos do Dashboard Remenu - Chart.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando gráficos do dashboard...');
    
    // Verificar se Chart.js está carregado
    if (typeof Chart === 'undefined') {
        console.error('Chart.js não está carregado!');
        return;
    }

    // Inicializar gráficos com dados reais
    initializeChartsWithRealData();
});

// Função para inicializar gráficos com dados reais
function initializeChartsWithRealData() {
    // Verificar se temos dados do PHP
    if (typeof chartData === 'undefined') {
        console.error('Dados dos gráficos não encontrados!');
        initializeChartsWithMockData();
        return;
    }

    console.log('Inicializando com dados reais:', chartData);

    try {
        // Gráfico 1: Receitas Mais Pesquisadas (Area Chart)
        const areaChartCanvas = document.getElementById('myAreaChart');
        if (areaChartCanvas && chartData.pesquisas && chartData.pesquisas.length > 0) {
            console.log('Criando gráfico de área com dados reais...');
            createAreaChart(areaChartCanvas, chartData.pesquisas);
        } else {
            console.warn('Dados de pesquisas não disponíveis, usando mock');
            createAreaChart(areaChartCanvas, getMockPesquisasData());
        }

        // Gráfico 2: Receitas em Destaque (Pie Chart)
        const pieChartCanvas = document.getElementById('myPieChart');
        if (pieChartCanvas && chartData.destaques && chartData.destaques.nomes) {
            console.log('Criando gráfico de pizza com dados reais...');
            createPieChart(pieChartCanvas, chartData.destaques);
        } else {
            console.warn('Dados de destaques não disponíveis, usando mock');
            createPieChart(pieChartCanvas, getMockDestaquesData());
        }

        // Gráfico 3: Top Favoritos (Bar Chart)
        const barChartCanvas = document.getElementById('myBarChart');
        if (barChartCanvas && chartData.favoritos && chartData.favoritos.length > 0) {
            console.log('Criando gráfico de barras com dados reais...');
            createBarChart(barChartCanvas, chartData.favoritos);
        } else {
            console.warn('Dados de favoritos não disponíveis, usando mock');
            createBarChart(barChartCanvas, getMockFavoritosData());
        }

        console.log('Todos os gráficos inicializados com sucesso!');

    } catch (error) {
        console.error('Erro ao inicializar gráficos:', error);
        // Fallback para dados mockados
        initializeChartsWithMockData();
    }
}

// Função para criar gráfico de área
function createAreaChart(canvas, dados) {
    const labels = dados.map(item => item.mes || item.nome);
    const values = dados.map(item => item.total);

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Pesquisas',
                data: values,
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' vezes';
                        }
                    }
                }
            }
        }
    });
}

// Função para criar gráfico de pizza
function createPieChart(canvas, dados) {
    new Chart(canvas, {
        type: 'pie',
        data: {
            labels: dados.nomes,
            datasets: [{
                data: dados.valores,
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

// Função para criar gráfico de barras
function createBarChart(canvas, dados) {
    const labels = dados.map(item => item.nome);
    const values = dados.map(item => item.total);

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Favoritos',
                data: values,
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' favoritos';
                        }
                    }
                }
            }
        }
    });
}

// Função fallback com dados mockados
function initializeChartsWithMockData() {
    console.log('Inicializando com dados mockados...');
    
    const areaChartCanvas = document.getElementById('myAreaChart');
    const pieChartCanvas = document.getElementById('myPieChart');
    const barChartCanvas = document.getElementById('myBarChart');

    if (areaChartCanvas) createAreaChart(areaChartCanvas, getMockPesquisasData());
    if (pieChartCanvas) createPieChart(pieChartCanvas, getMockDestaquesData());
    if (barChartCanvas) createBarChart(barChartCanvas, getMockFavoritosData());
}

// Dados mockados para fallback
function getMockPesquisasData() {
    return [
        {mes: 'Bolo Chocolate', total: 45},
        {mes: 'Frango Grelhado', total: 38},
        {mes: 'Salada Caesar', total: 32},
        {mes: 'Sopa Legumes', total: 28},
        {mes: 'Omelete Queijo', total: 25}
    ];
}

function getMockDestaquesData() {
    return {
        nomes: ['Salmão Grelhado', 'Quinoa Legumes', 'Frango Parmegiana', 'Salada Caesar', 'Smoothie Verde'],
        valores: [35, 28, 42, 38, 25]
    };
}

function getMockFavoritosData() {
    return [
        {nome: 'Bolo Chocolate Fit', total: 156},
        {nome: 'Frango Grelhado', total: 142},
        {nome: 'Salada Quinoa', total: 128},
        {nome: 'Sopa Legumes', total: 115},
        {nome: 'Omelete Espinafre', total: 98}
    ];
}

// Funções para atualizar gráficos em tempo real
function updateFavoritosChart(dados) {
    const chart = Chart.getChart('myBarChart');
    if (chart && dados && dados.length > 0) {
        chart.data.labels = dados.map(item => item.nome);
        chart.data.datasets[0].data = dados.map(item => item.total);
        chart.update();
        console.log('Gráfico de favoritos atualizado!');
    }
}

function updateDestaquesChart(dados) {
    const chart = Chart.getChart('myPieChart');
    if (chart && dados && dados.nomes) {
        chart.data.labels = dados.nomes;
        chart.data.datasets[0].data = dados.valores;
        chart.update();
        console.log('Gráfico de destaques atualizado!');
    }
}

function updatePesquisasChart(dados) {
    const chart = Chart.getChart('myAreaChart');
    if (chart && dados && dados.length > 0) {
        chart.data.labels = dados.map(item => item.mes || item.nome);
        chart.data.datasets[0].data = dados.map(item => item.total);
        chart.update();
        console.log('Gráfico de pesquisas atualizado!');
    }
}