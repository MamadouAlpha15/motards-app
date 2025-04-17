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


//protection des routes:pour acces uniquement a l'administrateur

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/liste',[MotardController::class, 'index'])->name('motards.index');
Route::get('/admin/settings', [AdminOnlyController::class, 'edit'])->name('admin.settings');
Route::post('/admin/settings', [AdminOnlyController::class, 'update'])->name('admin.settings.update');

});

Route::get('/motards/create',[MotardController::class, 'create'])->name('motards.create');
Route::post('/motards',[MotardController::class, 'store'])->name('motards.store');

//Route vers la fiche public via slug
Route::get('/motards/{slug}',[MotardController::class, 'show'])->name('motards.show');

//Route por générer le Qr code
Route::get('/motards/{id}/qr',[MotardController::class, 'qr'])->name('motards.qr');

// Carte imprimable
Route::get('/motards/{slug}/carte',[MotardController::class, 'carte'])->name('motards.carte');




