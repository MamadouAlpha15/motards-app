<?php

// Déclare que ce fichier est dans le namespace App\Http\Controllers
namespace App\Http\Controllers;

// On importe les classes nécessaires
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Définition de la classe AdminOnlyController qui étend Controller
class AdminOnlyController extends Controller
{
    /**
     * Affiche le formulaire pour modifier les informations de l'administrateur connecté.
     */
    public function edit()
    {
        $admin = Auth::user(); // Récupère l'utilisateur actuellement connecté (l'admin)
        return view('admin_settings', compact('admin')); // Affiche la vue admin_settings avec les infos de l'admin
    }

    /**
     * Met à jour les informations de l'administrateur.
     */
    public function update(Request $request)
    {
        // Valide les données envoyées par le formulaire
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(), // L'email doit être unique sauf pour l'utilisateur actuel
            'password' => 'nullable|min:8|confirmed', // Le mot de passe est facultatif, mais s'il existe il doit être confirmé et avoir au moins 8 caractères
        ]);

        $admin = Auth::user(); // Récupère l'admin connecté
        $admin->email = $request->email; // Met à jour son adresse email

        if ($request->password) {
            // Si un mot de passe est fourni, on le crypte avant de l'enregistrer
            $admin->password = Hash::make($request->password);
        }

        $admin->save(); // Enregistre les modifications dans la base de données

        // Redirige l'utilisateur vers la même page avec un message de succès
        return back()->with('success', 'Informations mises à jour avec succès.');
    }
}
