<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Affiche la liste de tous les administrateurs
    public function index()
    {
        $admins = User::where('is_admin', true)->get();
        return view('admin_liste', compact('admins'));
    }

    // Supprime un administrateur
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Empêche la suppression de soi-même
        if ($admin->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        $admin->delete();

        return back()->with('success', 'Administrateur supprimé avec succès.');
    }
}
