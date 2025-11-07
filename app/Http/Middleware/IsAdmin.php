<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\TipoUsuario;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo_id === TipoUsuario::ADMIN) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Acesso não autorizado.');
    }
}

