<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotardController;
use App\Http\Controllers\AdminOnlyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;

// Page d’accueil redirige vers publicité
Route::get('/', fn () => redirect()->route('motards.pub'));

// Page de login
Route::get('/login', fn () => view('auth_login'))->name('login')->middleware('guest');

// Authentification
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/liste');
    }
    return back()->withErrors(['email' => 'Email incorrect ou mot de passe incorrect.'])->withInput();
})->name('login');

// Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Routes protégées par auth + admin
Route::middleware(['auth', 'admin'])->group(function () {

    // Gestion motards
    Route::get('/liste', [MotardController::class, 'index'])->name('motards.index');
    Route::get('/motards/create', [MotardController::class, 'create'])->name('motards.create');
    Route::post('/motards', [MotardController::class, 'store'])->name('motards.store');
    Route::get('/motards/{id}/edit', [MotardController::class, 'edit'])->name('motards.edit');
    Route::put('/motards/{id}', [MotardController::class, 'update'])->name('motards.update');
    Route::delete('/motards/{id}', [MotardController::class, 'destroy'])->name('motards.destroy');
    Route::POST('/motards/delete-selected', [MotardController::class, 'deleteSelected'])->name('motards.deleteSelected');
    Route::get('/motards/imprimer-selection', [MotardController::class, 'imprimerSelection'])->name('motards.imprimerSelection');

    // Paramètres admin
    Route::get('/admin/settings', [AdminOnlyController::class, 'edit'])->name('admin.settings');
    Route::post('/admin/settings', [AdminOnlyController::class, 'update'])->name('admin.settings.update');

   // 👇 Seulement le super admin peut gérer les comptes admin
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/saved', [RegisteredUserController::class, 'store'])->name('user.store');
        Route::get('/admin/liste', [AdminController::class, 'index'])->name('admin.liste');
        Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.supprimer');
        });

});

// Vues publiques
Route::get('/pub', [MotardController::class, 'publicite'])->name('motards.pub');
Route::get('/motards/{id}/qr', [MotardController::class, 'qr'])->name('motards.qr');
Route::get('/motards/{slug}/carte', [MotardController::class, 'carte'])->name('motards.carte');
Route::get('/motards/{slug}', [MotardController::class, 'show'])->name('motards.show');
