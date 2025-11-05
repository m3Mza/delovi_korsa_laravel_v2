<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate the input
        $request->validate([
            'ime' => 'required|string|max:100',
            'prezime' => 'required|string|max:100',
            'email' => 'required|email|unique:korisnici,email',
            'lozinka' => 'required|string|min:6|confirmed',
            'telefon' => 'nullable|string|max:20',
            'adresa' => 'nullable|string',
        ]);

        // Create new kupac user
        $korisnik = Korisnik::create([
            'ime' => $request->ime,
            'prezime' => $request->prezime,
            'email' => $request->email,
            'lozinka' => Hash::make($request->lozinka),
            'tip_korisnika' => 'kupac', // Always create as kupac
            'telefon' => $request->telefon,
            'adresa' => $request->adresa,
        ]);

        // Log the user in
        Auth::login($korisnik);

        return redirect()->route('home')->with('success', 'Uspešno ste se registrovali!');
    }
}
