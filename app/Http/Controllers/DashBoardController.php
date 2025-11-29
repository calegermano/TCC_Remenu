<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Favorito;
use App\Models\Planejamento;
use App\Services\FatSecretService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DashBoardController extends Controller
{
    protected $fatSecretService;

    public function __construct(FatSecretService $fatSecretService)
    {
        $this->fatSecretService = $fatSecretService;
    }

    public function index()
    {
        try {
            // Dados básicos
            $totalUsuarios = Usuario::count();
            $totalFavoritos = Favorito::count();
            $totalPlanejamentos = Planejamento::where('date', '>=', now()->format('Y-m-d'))->count();
            
            // Buscar quantidade de receitas da API FatSecret
            $receitasData = $this->fatSecretService->getRecipes('a', [], 0);
            $totalReceitas = $receitasData['total_results'] ?? 0;

            // Dados para os gráficos
            $graficoFavoritos = $this->getTopFavoritos();
            $graficoDestaques = $this->getReceitasEmDestaque();
            $graficoPesquisas = $this->getReceitasMaisPesquisadas();

            return view('dashboard.index', compact(
                'totalUsuarios',
                'totalReceitas', 
                'totalFavoritos',
                'totalPlanejamentos',
                'graficoFavoritos',
                'graficoDestaques', 
                'graficoPesquisas'
            ));

        } catch (\Exception $e) {
            Log::error('Erro no DashboardController: ' . $e->getMessage());
            
            return view('dashboard.index', [
                'totalUsuarios' => Usuario::count() ?: 0,
                'totalReceitas' => 0,
                'totalFavoritos' => Favorito::count() ?: 0,
                'totalPlanejamentos' => Planejamento::where('date', '>=', now()->format('Y-m-d'))->count() ?: 0,
                'graficoFavoritos' => [],
                'graficoDestaques' => [],
                'graficoPesquisas' => []
            ]);
        }
    }

    /**
     * Top receitas favoritadas (Gráfico 3)
     */
    private function getTopFavoritos()
    {
        return Favorito::select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->orderBy('total', 'DESC')
            ->limit(8)
            ->get()
            ->map(function($item) {
                return [
                    'nome' => $item->name,
                    'total' => $item->total
                ];
            })
            ->toArray();
    }

    /**
     * Receitas em destaque (Gráfico 2)
     * Baseado em: favoritos + planejamentos + pesquisas (simulado)
     */
    private function getReceitasEmDestaque()
    {
        // Buscar receitas mais favoritadas
        $favoritos = Favorito::select('name', DB::raw('COUNT(*) as score'))
            ->groupBy('name')
            ->get();

        // Buscar receitas mais planejadas
        $planejamentos = Planejamento::select('recipe_name as name', DB::raw('COUNT(*) as score'))
            ->groupBy('recipe_name')
            ->get();

        // Combinar e calcular score total
        $receitas = [];
        
        // Adicionar favoritos
        foreach ($favoritos as $favorito) {
            $receitas[$favorito->name] = ($receitas[$favorito->name] ?? 0) + $favorito->score * 3;
        }
        
        // Adicionar planejamentos
        foreach ($planejamentos as $planejamento) {
            $receitas[$planejamento->name] = ($receitas[$planejamento->name] ?? 0) + $planejamento->score * 2;
        }

        // Ordenar por score e pegar top 5
        arsort($receitas);
        $topReceitas = array_slice($receitas, 0, 5, true);

        // Se não houver dados, usar dados de exemplo
        if (empty($topReceitas)) {
            return [
                'nomes' => ['Bolo Chocolate', 'Frango Grelhado', 'Salada Caesar', 'Sopa Legumes', 'Omelete Queijo'],
                'valores' => [45, 38, 32, 28, 25]
            ];
        }

        return [
            'nomes' => array_keys($topReceitas),
            'valores' => array_values($topReceitas)
        ];
    }

    /**
     * Receitas mais pesquisadas (Gráfico 1)
     * Nota: Você precisará criar uma tabela de logs de pesquisa para isso funcionar
     * Por enquanto, vamos simular com dados das receitas mais interagidas
     */
    private function getReceitasMaisPesquisadas()
    {
        // Simulação - usar receitas com mais interações
        $interacoes = Favorito::select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->orderBy('total', 'DESC')
            ->limit(12)
            ->get()
            ->map(function($item) {
                return [
                    'mes' => $item->name,
                    'total' => $item->total
                ];
            })
            ->toArray();

        // Se não houver dados, usar dados de exemplo
        if (empty($interacoes)) {
            return [
                ['mes' => 'Bolo Chocolate', 'total' => 45],
                ['mes' => 'Frango Grelhado', 'total' => 38],
                ['mes' => 'Salada Caesar', 'total' => 32],
                ['mes' => 'Sopa Legumes', 'total' => 28],
                ['mes' => 'Omelete Queijo', 'total' => 25],
                ['mes' => 'Pão Integral', 'total' => 22],
                ['mes' => 'Smoothie Verde', 'total' => 20],
                ['mes' => 'Quinoa', 'total' => 18],
                ['mes' => 'Salmão', 'total' => 15],
                ['mes' => 'Torta Frango', 'total' => 12],
                ['mes' => 'Vitamina Banana', 'total' => 10],
                ['mes' => 'Iogurte Natural', 'total' => 8]
            ];
        }

        return $interacoes;
    }

    /**
     * API para dados dos gráficos em tempo real
     */
    public function getChartData()
    {
        try {
            $data = [
                'favoritos' => $this->getTopFavoritos(),
                'destaques' => $this->getReceitasEmDestaque(),
                'pesquisas' => $this->getReceitasMaisPesquisadas(),
                'updated_at' => now()->format('d/m/Y H:i:s')
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Erro na API de gráficos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar dados dos gráficos'], 500);
        }
    }

    /**
     * API para estatísticas básicas
     */
    public function getStats()
    {
        try {
            $stats = [
                'totalUsuarios' => Usuario::count(),
                'totalFavoritos' => Favorito::count(),
                'totalPlanejamentos' => Planejamento::where('date', '>=', now()->format('Y-m-d'))->count(),
                'updated_at' => now()->format('d/m/Y H:i:s')
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar estatísticas'], 500);
        }
    }

    /**
     * Gerar relatório em PDF
     */
    public function generateReport()
    {
        try {
            // Buscar os mesmos dados do dashboard
            $totalUsuarios = Usuario::count();
            $totalFavoritos = Favorito::count();
            $totalPlanejamentos = Planejamento::where('date', '>=', now()->format('Y-m-d'))->count();
            
            $receitasData = $this->fatSecretService->getRecipes('a', [], 0);
            $totalReceitas = $receitasData['total_results'] ?? 0;

            $graficoFavoritos = $this->getTopFavoritos();
            $graficoDestaques = $this->getReceitasEmDestaque();
            $graficoPesquisas = $this->getReceitasMaisPesquisadas();

            $data = [
                'totalUsuarios' => $totalUsuarios,
                'totalReceitas' => $totalReceitas,
                'totalFavoritos' => $totalFavoritos,
                'totalPlanejamentos' => $totalPlanejamentos,
                'graficoFavoritos' => $graficoFavoritos,
                'graficoDestaques' => $graficoDestaques,
                'graficoPesquisas' => $graficoPesquisas,
                'dataGeracao' => now()->format('d/m/Y H:i:s'),
                'periodo' => 'Período: ' . now()->subMonth()->format('d/m/Y') . ' a ' . now()->format('d/m/Y')
            ];

            // Gerar PDF
            $pdf = Pdf::loadView('dashboard.report', $data);

            // Configurar o papel para A4 landscape para melhor visualização
            $pdf->setPaper('a4', 'portrait');
            
            // Opção 1: Download direto
            return $pdf->download('relatorio-dashboard-remenu-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Erro ao gerar relatório PDF: ' . $e->getMessage());
            return back()->with('error', 'Erro ao gerar relatório: ' . $e->getMessage());
        }
    }

    /**
     * Visualizar relatório PDF no navegador (opcional)
     */
    public function viewReport()
    {
        try {
            // Buscar os mesmos dados do dashboard
            $totalUsuarios = Usuario::count();
            $totalFavoritos = Favorito::count();
            $totalPlanejamentos = Planejamento::where('date', '>=', now()->format('Y-m-d'))->count();
            
            $receitasData = $this->fatSecretService->getRecipes('a', [], 0);
            $totalReceitas = $receitasData['total_results'] ?? 0;

            $graficoFavoritos = $this->getTopFavoritos();
            $graficoDestaques = $this->getReceitasEmDestaque();
            $graficoPesquisas = $this->getReceitasMaisPesquisadas();

            $data = [
                'totalUsuarios' => $totalUsuarios,
                'totalReceitas' => $totalReceitas,
                'totalFavoritos' => $totalFavoritos,
                'totalPlanejamentos' => $totalPlanejamentos,
                'graficoFavoritos' => $graficoFavoritos,
                'graficoDestaques' => $graficoDestaques,
                'graficoPesquisas' => $graficoPesquisas,
                'dataGeracao' => now()->format('d/m/Y H:i:s'),
                'periodo' => 'Período: ' . now()->subMonth()->format('d/m/Y') . ' a ' . now()->format('d/m/Y')
            ];

            // Gerar PDF para visualização no navegador
            $pdf = Pdf::loadView('dashboard.report', $data);
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->stream('relatorio-dashboard-remenu-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Erro ao visualizar relatório PDF: ' . $e->getMessage());
            return back()->with('error', 'Erro ao gerar relatório: ' . $e->getMessage());
        }
    }
}