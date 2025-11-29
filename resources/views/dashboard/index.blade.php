<x-layout>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard Remenu</h1>
            <small class="text-muted" id="dashboardDateTime">
                Atualizado em: {{ now()->format('d/m/Y H:i') }}
            </small>
        </div>
        <div>
    <button onclick="refreshStats()" class="btn btn-sm btn-outline-primary mr-2">
        <i class="fas fa-sync-alt fa-sm"></i> Atualizar
    </button>
    <a href="{{ route('admin.dashboard.report') }}" 
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
       onclick="showPDFLoading()">
        <i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatório PDF
    </a>
</div>

<script>
function showPDFLoading() {
    // Feedback visual enquanto gera o PDF
    const btn = event.target;
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm"></i> Gerando PDF...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    }, 3000);
}
</script>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total de Usuários -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Usuários</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsuarios">
                                {{ number_format($totalUsuarios) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-muted">
                        <i class="fas fa-database fa-sm"></i> Cadastrados no sistema
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Receitas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Receitas Disponíveis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalReceitas">
                                {{ number_format($totalReceitas) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-muted">
                        <i class="fas fa-cloud fa-sm"></i> Via API FatSecret
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Favoritos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Favoritos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalFavoritos">
                                {{ number_format($totalFavoritos) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-muted">
                        <i class="fas fa-star fa-sm"></i> Receitas favoritadas
                    </div>
                </div>
            </div>
        </div>

        <!-- Planejamentos Ativos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Planejamentos Ativos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalPlanejamentos">
                                {{ number_format($totalPlanejamentos) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-muted">
                        <i class="fas fa-clock fa-sm"></i> Próximos 7 dias
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Content Row - Gráficos -->
    <div class="row">

        <!-- Gráfico 1: Receitas Mais Pesquisadas -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Receitas Mais Pesquisadas</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                    <div class="mt-4 small text-muted">
                        <i class="fas fa-info-circle"></i>
                        Ranking das receitas mais pesquisadas pelos usuários
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Receitas em Destaque -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Receitas em Destaque</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 small text-muted">
                        <i class="fas fa-info-circle"></i>
                        Proporção de receitas em destaque na aplicação
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Gráfico de Favoritos -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Receitas Favoritas</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                    <div class="mt-4 small text-muted">
                        <i class="fas fa-info-circle"></i>
                        Ranking das receitas mais marcadas como favoritas pelos usuários
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Adicionais -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estatísticas Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Média de Favoritos por Usuário:</strong></p>
                            <p class="text-info">
                                @if($totalUsuarios > 0)
                                    {{ number_format($totalFavoritos / $totalUsuarios, 1) }} receitas
                                @else
                                    0 receitas
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Taxa de Engajamento:</strong></p>
                            <p class="text-success">
                                @if($totalUsuarios > 0)
                                    {{ number_format((($totalFavoritos + $totalPlanejamentos) / $totalUsuarios) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Receitas por Usuário:</strong></p>
                            <p class="text-primary">
                                @if($totalUsuarios > 0)
                                    {{ number_format($totalReceitas / $totalUsuarios, 0) }} disponíveis
                                @else
                                    0 disponíveis
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Planejamentos por Usuário:</strong></p>
                            <p class="text-warning">
                                @if($totalUsuarios > 0)
                                    {{ number_format($totalPlanejamentos / $totalUsuarios, 1) }} ativos
                                @else
                                    0 ativos
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sobre os Dados</h6>
                </div>
                <div class="card-body">
                    <p>Os dados apresentados são baseados nas interações reais dos usuários na plataforma Remenu:</p>
                    <ul>
                        <li><strong>Usuários:</strong> Total de cadastros ativos no sistema</li>
                        <li><strong>Receitas:</strong> Quantidade disponível via API FatSecret</li>
                        <li><strong>Favoritos:</strong> Receitas marcadas como favoritas pelos usuários</li>
                        <li><strong>Planejamentos:</strong> Refeições agendadas para os próximos dias</li>
                    </ul>
                    <p class="mb-0">Dados atualizados em tempo real conforme a interação dos usuários.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
// Função para atualizar estatísticas em tempo real
function refreshStats() {
    const refreshBtn = event.target;
    const originalHtml = refreshBtn.innerHTML;
    
    // Mostrar loading
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm"></i> Atualizando...';
    refreshBtn.disabled = true;

    fetch('{{ route("admin.dashboard.stats") }}')
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                // Atualizar os valores
                document.getElementById('totalUsuarios').textContent = data.totalUsuarios.toLocaleString();
                document.getElementById('totalFavoritos').textContent = data.totalFavoritos.toLocaleString();
                document.getElementById('totalPlanejamentos').textContent = data.totalPlanejamentos.toLocaleString();
                
                // Atualizar data/hora
                document.getElementById('dashboardDateTime').textContent = 'Atualizado em: ' + data.updated_at;
                
                // Mostrar mensagem de sucesso
                showAlert('Estatísticas atualizadas com sucesso!', 'success');
            } else {
                showAlert('Erro ao atualizar estatísticas', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao conectar com o servidor', 'error');
        })
        .finally(() => {
            // Restaurar botão
            refreshBtn.innerHTML = originalHtml;
            refreshBtn.disabled = false;
        });
}

function showAlert(message, type) {
    // Criar alerta temporário
    const alert = document.createElement('div');
    alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.querySelector('.container-fluid').insertBefore(alert, document.querySelector('.row'));
    
    // Remover após 3 segundos
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

// Atualizar automaticamente a cada 2 minutos
setInterval(refreshStats, 120000);
</script>

<script>
// Passar dados do PHP para JavaScript
const chartData = {
    favoritos: @json($graficoFavoritos),
    destaques: @json($graficoDestaques),
    pesquisas: @json($graficoPesquisas)
};

console.log('Dados dos gráficos:', chartData);

// Função para atualizar gráficos com dados reais
function updateChartsWithRealData() {
    fetch('{{ route("admin.dashboard.chart-data") }}')
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                updateFavoritosChart(data.favoritos);
                updateDestaquesChart(data.destaques);
                updatePesquisasChart(data.pesquisas);
                console.log('Gráficos atualizados com dados reais!');
            }
        })
        .catch(error => {
            console.error('Erro ao atualizar gráficos:', error);
        });
}

// Atualizar a cada 2 minutos
setInterval(updateChartsWithRealData, 120000);

// Chamar inicialmente
updateChartsWithRealData();
</script>

<script>
// Teste de diagnóstico
console.log('=== DIAGNÓSTICO DASHBOARD ===');
console.log('Chart.js carregado:', typeof Chart !== 'undefined');
console.log('Dados chartData:', typeof chartData !== 'undefined' ? chartData : 'NÃO ENCONTRADO');

// Verificar elementos canvas
console.log('Canvas myAreaChart:', document.getElementById('myAreaChart'));
console.log('Canvas myPieChart:', document.getElementById('myPieChart'));
console.log('Canvas myBarChart:', document.getElementById('myBarChart'));

// Verificar gráficos existentes
console.log('Gráfico Area existente:', Chart.getChart('myAreaChart'));
console.log('Gráfico Pie existente:', Chart.getChart('myPieChart'));
console.log('Gráfico Bar existente:', Chart.getChart('myBarChart'));
</script>

</x-layout>