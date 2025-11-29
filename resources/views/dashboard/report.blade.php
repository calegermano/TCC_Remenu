<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório Dashboard - Remenu</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4e73df;
            margin: 0;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-item {
            text-align: center;
            padding: 15px;
            border-radius: 5px;
            background: white;
            border: 1px solid #e3e6f0;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #4e73df;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background: #4e73df;
            color: white;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        .table th {
            background: #f8f9fc;
            font-weight: bold;
        }
        .table-striped tr:nth-child(even) {
            background: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório Dashboard - Remenu</h1>
        <div class="subtitle">{{ $periodo }}</div>
        <div>Gerado em: {{ $dataGeracao }}</div>
    </div>

    <!-- Estatísticas Principais -->
    <div class="section">
        <div class="section-title">Estatísticas Principais</div>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalUsuarios) }}</div>
                <div class="stat-label">Total de Usuários</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalReceitas) }}</div>
                <div class="stat-label">Receitas Disponíveis</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalFavoritos) }}</div>
                <div class="stat-label">Favoritos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalPlanejamentos) }}</div>
                <div class="stat-label">Planejamentos Ativos</div>
            </div>
        </div>
    </div>

    <!-- Top Receitas Favoritas -->
    <div class="section">
        <div class="section-title">Top Receitas Favoritas</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Receita</th>
                    <th>Total de Favoritos</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($graficoFavoritos, 0, 10) as $index => $favorito)
                <tr>
                    <td>{{ $index + 1 }}º</td>
                    <td>{{ $favorito['nome'] }}</td>
                    <td>{{ $favorito['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Receitas em Destaque -->
    <div class="section">
        <div class="section-title">Receitas em Destaque</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Receita</th>
                    <th>Score de Engajamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($graficoDestaques['nomes'] as $index => $nome)
                <tr>
                    <td>{{ $index + 1 }}º</td>
                    <td>{{ $nome }}</td>
                    <td>{{ $graficoDestaques['valores'][$index] }} pontos</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card">
            <strong>Como é calculado:</strong><br>
            Score = (Favoritos × 3) + (Planejamentos × 2)
        </div>
    </div>

    <!-- Receitas Mais Pesquisadas -->
    <div class="section">
        <div class="section-title">Receitas Mais Pesquisadas</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Receita</th>
                    <th>Total de Interações</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($graficoPesquisas, 0, 10) as $index => $pesquisa)
                <tr>
                    <td>{{ $index + 1 }}º</td>
                    <td>{{ $pesquisa['mes'] ?? $pesquisa['nome'] }}</td>
                    <td>{{ $pesquisa['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Estatísticas Avançadas -->
    <div class="section">
        <div class="section-title">Estatísticas Avançadas</div>
        <div class="card">
            <table class="table">
                <tr>
                    <td><strong>Média de Favoritos por Usuário:</strong></td>
                    <td>
                        @if($totalUsuarios > 0)
                            {{ number_format($totalFavoritos / $totalUsuarios, 1) }} receitas
                        @else
                            0 receitas
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Taxa de Engajamento:</strong></td>
                    <td>
                        @if($totalUsuarios > 0)
                            {{ number_format((($totalFavoritos + $totalPlanejamentos) / $totalUsuarios) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Receitas por Usuário:</strong></td>
                    <td>
                        @if($totalUsuarios > 0)
                            {{ number_format($totalReceitas / $totalUsuarios, 0) }} disponíveis
                        @else
                            0 disponíveis
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Planejamentos por Usuário:</strong></td>
                    <td>
                        @if($totalUsuarios > 0)
                            {{ number_format($totalPlanejamentos / $totalUsuarios, 1) }} ativos
                        @else
                            0 ativos
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        Relatório gerado automaticamente pelo Sistema Remenu<br>
        {{ $dataGeracao }} | Página 1 de 1
    </div>
</body>
</html>