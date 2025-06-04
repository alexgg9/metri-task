<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Permitir acceso a rutas de autenticación
        if ($request->is('admin/login') || $request->is('admin/forgot-password')) {
            return $next($request);
        }

        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
