<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUnauthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Se o usuário não estiver autenticado
        if (!Auth::check()) {
            // Verifica se é uma requisição de interação (não GET ou específica para visualização)
            if ($this->isInteractionRequest($request)) {
                // Armazena a URL completa de origem na sessão
                session()->put('url.intended', $request->fullUrl());
                
                // Armazena também os dados do formulário se for POST/PUT/PATCH
                if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
                    session()->flash('form.data', $request->all());
                }
                
                // Redireciona para a página de cadastro
                return redirect()->route('register.form')->with('warning', 'Por favor, faça cadastro ou login para continuar.');
            }
        }

        // Se estiver autenticado ou for uma requisição de visualização, permite continuar
        return $next($request);
    }

    /**
     * Verifica se a requisição é uma interação do usuário
     */
    private function isInteractionRequest(Request $request): bool
    {
        // Métodos HTTP que representam interações
        $interactionMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
        
        // Rotas de visualização estática que NÃO devem ser interceptadas
        $staticRoutes = [
            '/', '/home', '/home2', '/senha', '/login', '/register',
            '/receitas', '/footer', '/header', '/receitas/*'
        ];

        // Se for uma requisição GET para uma rota que não é estática, considera como interação
        if ($request->isMethod('GET')) {
            // Verifica se a rota atual NÃO está na lista de rotas estáticas
            foreach ($staticRoutes as $route) {
                if ($request->is($route)) {
                    return false;
                }
            }
            // Se é um GET mas não é uma rota estática, considera como interação
            return true;
        }

        // Para outros métodos, verifica se é um método de interação
        return in_array($request->method(), $interactionMethods);
    }
}