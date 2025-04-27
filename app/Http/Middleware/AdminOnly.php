<?php

// Ce fichier appartient au namespace App\Http\Middleware
namespace App\Http\Middleware;

// On importe les classes nécessaires
use Closure;
use Illuminate\Support\Facades\Auth;

// Définition de la classe AdminOnly
class AdminOnly
{
    /**
     * Ce middleware permet de bloquer l'accès aux utilisateurs qui ne sont pas administrateurs.
     */
    public function handle($request, Closure $next)
    {
        // Vérifie si un utilisateur est connecté ET que c'est un administrateur
        if (Auth::check() && Auth::user()->is_admin) {
            // Si oui, il continue vers la page demandée
            return $next($request);
        }

        // Sinon, on bloque l'accès avec une erreur 403 "Accès refusé"
        abort(403, 'Accès refusé. Seul l\'administrateur peut voir cette page.');
    }
}
