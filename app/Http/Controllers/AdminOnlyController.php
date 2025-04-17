<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminOnlyController extends Controller

{
    public function edit()
    {
        $admin = Auth::user();
        return view('admin_settings', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        $admin = Auth::user();
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();
       


        return back()->with('success', 'Informations mises à jour avec succès.');
    }
   
}

