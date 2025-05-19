<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // Affiche le formulaire pour saisir l’email
    public function showForgotForm()
    {
        return view('forgot_password_email');
    }

    // Vérifie si l’email existe et redirige vers le formulaire de nouveau mot de passe
    public function handleForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Stocke l’email en session pour l’utiliser après
        session(['reset_email' => $request->email]);

        return redirect()->route('password.reset.form');
    }

    // Formulaire pour saisir le nouveau mot de passe
    public function showResetForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Aucune session active.']);
        }

        return view('reset_password_form');
    }

    // Enregistre le nouveau mot de passe
    public function handleReset(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès.');
    }
}
