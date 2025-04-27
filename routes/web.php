<?php

// Importation des classes nécessaires
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotardController;
use App\Http\Controllers\AdminOnlyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Fichier pour définir toutes les routes web de l'application.
| Chargé automatiquement par Laravel.
|
*/

// Quand on accède à la racine du site ("/"), on redirige vers la page publicité
Route::get('/', function () {
    return redirect()->route('motards.pub');
});

// Affiche le formulaire de connexion
Route::get('/login', function () {
    return view('auth_login');
})->name('login')->middleware('guest'); // Accessible uniquement pour les invités (non connectés)

// Traitement des données du formulaire de connexion
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password'); // Récupère email et mot de passe

    // Vérifie si les informations sont correctes
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // Regénère la session pour sécurité
        return redirect()->intended('/liste'); // Redirige vers la liste des motards
    }

    // Si échec, retourne au formulaire avec une erreur
    return back()
        ->withErrors([
            'email' => 'Email incorrect ou mot de passe incorrect.',
        ])
        ->withInput();
})->name('login');

// Déconnexion de l'utilisateur
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Déconnecte l'utilisateur
    $request->session()->invalidate(); // Invalide la session actuelle
    $request->session()->regenerateToken(); // Regénère un nouveau token CSRF
    return redirect('/login'); // Redirige vers la page de connexion
})->name('logout');

// Routes accessibles uniquement par les administrateurs connectés
Route::middleware(['auth', 'admin'])->group(function () {

    // Affiche la liste des motards
    Route::get('/liste', [MotardController::class, 'index'])->name('motards.index');

    // Formulaire pour ajouter un nouveau motard
    Route::get('/motards/create', [MotardController::class, 'create'])->name('motards.create');

    // Enregistrement du nouveau motard
    Route::post('/motards', [MotardController::class, 'store'])->name('motards.store');

    // Formulaire de modification des paramètres admin
    Route::get('/admin/settings', [AdminOnlyController::class, 'edit'])->name('admin.settings');

    // Traitement de la mise à jour des paramètres admin
    Route::post('/admin/settings', [AdminOnlyController::class, 'update'])->name('admin.settings.update');

    // Formulaire d'édition des informations d'un motard
    Route::get('/motards/{id}/edit', [MotardController::class, 'edit'])->name('motards.edit');

    // Mise à jour des informations d'un motard
    Route::put('/motards/{id}', [MotardController::class, 'update'])->name('motards.update');

    // Suppression d'un motard
    Route::delete('/motards/{id}', [MotardController::class, 'destroy'])->name('motards.destroy');
});

// Page publique de publicité/information sur les motards
Route::get('/pub', [MotardController::class, 'publicite'])->name('motards.pub');

// Génération du QR code pour un motard spécifique
Route::get('/motards/{id}/qr', [MotardController::class, 'qr'])->name('motards.qr');

// Génération de la carte imprimable d'un motard
Route::get('/motards/{slug}/carte', [MotardController::class, 'carte'])->name('motards.carte');

// Affiche la fiche publique d'un motard via son slug
Route::get('/motards/{slug}', [MotardController::class, 'show'])->name('motards.show');
