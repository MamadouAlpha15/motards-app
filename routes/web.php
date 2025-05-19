<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotardController;
use App\Http\Controllers\AdminOnlyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Commune;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Page d’accueil → redirection vers la publicité publique
Route::get('/', fn () => redirect()->route('motards.pub'));

// Page de login
Route::get('/login', fn () => view('auth_login'))->name('login')->middleware('guest');

//Route pour mot de passe oublier 
Route::get('/mot-de-passe-oublie', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/mot-de-passe-oublie', [ForgotPasswordController::class, 'handleForgot'])->name('password.email');
Route::get('/reinitialiser-mot-de-passe', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reinitialiser-mot-de-passe', [ForgotPasswordController::class, 'handleReset'])->name('password.reset');


// Traitement de l’authentification
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirection selon rôle
        return Auth::user()->is_super_admin
            ? redirect('/choix-commune')
            : redirect('/liste');
    }

    return back()->withErrors([
        'email' => 'Email incorrect ou mot de passe incorrect.'
    ])->withInput();
})->name('login');

// Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// 🔐 Routes protégées par authentification + rôle admin
Route::middleware(['auth', 'admin'])->group(function () {

    // 📋 Motards
    Route::get('/liste', [MotardController::class, 'index'])->name('motards.index');
    Route::get('/motards/create', [MotardController::class, 'create'])->name('motards.create');
    Route::post('/motards', [MotardController::class, 'store'])->name('motards.store');
    Route::get('/motards/{id}/edit', [MotardController::class, 'edit'])->name('motards.edit');
    Route::put('/motards/{id}', [MotardController::class, 'update'])->name('motards.update');
    Route::delete('/motards/{id}', [MotardController::class, 'destroy'])->name('motards.destroy');
    Route::post('/motards/delete-selected', [MotardController::class, 'deleteSelected'])->name('motards.deleteSelected');
    Route::get('/motards/imprimer-selection', [MotardController::class, 'imprimerSelection'])->name('motards.imprimerSelection');

    // ⚙️ Paramètres admin
    Route::get('/admin/settings', [AdminOnlyController::class, 'edit'])->name('admin.settings');
    Route::post('/admin/settings', [AdminOnlyController::class, 'update'])->name('admin.settings.update');

    // 👑 Routes réservées au super administrateur
    Route::middleware(['superadmin'])->group(function () {

        // ➕ Création des administrateurs
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/saved', [RegisteredUserController::class, 'store'])->name('user.store');

        // 👤 Liste des admins
        Route::get('/admin/liste', [AdminController::class, 'index'])->name('admin.liste');
        Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.supprimer');

        // 🌍 Choix d'une commune
        Route::get('/choix-commune', function () {
            $communes = Commune::all();
            return view('communes', compact('communes'));
        })->name('communes.choix');
    });
});

// 🌐 Pages publiques (QR / Carte / Fiche)
Route::get('/pub', [MotardController::class, 'publicite'])->name('motards.pub');
Route::get('/motards/{id}/qr', [MotardController::class, 'qr'])->name('motards.qr');
Route::get('/motards/{slug}/carte', [MotardController::class, 'carte'])->name('motards.carte');
Route::get('/motards/{slug}', [MotardController::class, 'show'])->name('motards.show');
