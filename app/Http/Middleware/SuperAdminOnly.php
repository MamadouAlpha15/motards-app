<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminOnly
{
    public function handle($request, Closure $next)
    {
        // 🔐 Vérifie si l'utilisateur est connecté et super admin
        if (Auth::check() && Auth::user()->is_super_admin) {
            return $next($request);
        }

        // ❌ Sinon on bloque l'accès
        abort(403, "Accès réservé au Super Administrateur");
    }
}
