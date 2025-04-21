<?php

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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirection vers la page pub à l'accueil
Route::get('/', function () {
    return redirect()->route('motards.pub');
});

// Formulaire de login
Route::get('/login', function () {
    return view('auth_login');
})->name('login')->middleware('guest');

// Traitement du login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/liste');
    }

    return back()
        ->withErrors([
            'email' => 'Email incorrect ou mot de passe incorrect.',
        ])
        ->withInput();
})->name('login');

// Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Routes protégées (admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/liste', [MotardController::class, 'index'])->name('motards.index');
    Route::get('/motards/create', [MotardController::class, 'create'])->name('motards.create');
    Route::post('/motards', [MotardController::class, 'store'])->name('motards.store');
    Route::get('/admin/settings', [AdminOnlyController::class, 'edit'])->name('admin.settings');
    Route::post('/admin/settings', [AdminOnlyController::class, 'update'])->name('admin.settings.update');
   // Formulaire d’édition
Route::get('/motards/{id}/edit', [MotardController::class, 'edit'])->name('motards.edit');

// Mise à jour du motard
Route::put('/motards/{id}', [MotardController::class, 'update'])->name('motards.update');

// Suppression du motard
Route::delete('/motards/{id}', [MotardController::class, 'destroy'])->name('motards.destroy');

});

// Page de publicité publique
Route::get('/pub', [MotardController::class, 'publicite'])->name('motards.pub');

// Routes QR code et carte
Route::get('/motards/{id}/qr', [MotardController::class, 'qr'])->name('motards.qr');
Route::get('/motards/{slug}/carte', [MotardController::class, 'carte'])->name('motards.carte');

// Route publique (fiche motard)
Route::get('/motards/{slug}', [MotardController::class, 'show'])->name('motards.show');
