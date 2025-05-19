<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Commune;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'enregistrement d'un administrateur
     */
    public function create(): View
    {
        $communes = Commune::all();
        return view('auth_register', compact('communes'));
    }

    /**
     * Enregistre un nouvel administrateur d'une commune
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des champs
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'commune_id' => ['required', 'exists:communes,id'],
        ]);

        // Création de l'admin
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'commune_id' => $request->commune_id,
        ]);

        // 🔁 Redirection vers la commune du nouvel admin
        $commune = Commune::find($user->commune_id);

        return redirect()->route('motards.index', ['commune' => $commune->slug])
                         ->with('success', 'Administrateur créé avec succès.');
    }
}
