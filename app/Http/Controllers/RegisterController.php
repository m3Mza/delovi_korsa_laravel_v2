<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Register Controller
 * Registrovani korisnici automatski dobijaju tip 'kupac'.
 */
class RegisterController extends Controller
{
    /**
     * Prikaži formu za registraciju
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Obradi registraciju novog korisnika
     */
    public function register(Request $request)
    {
        // Validacija unetih podataka
        $request->validate([
            'ime' => 'required|string|max:100',
            'prezime' => 'required|string|max:100',
            'email' => 'required|email|unique:korisnici,email',
            'lozinka' => 'required|string|min:6|confirmed',
            'telefon' => 'nullable|string|max:20',
            'adresa' => 'nullable|string',
        ]);

        // Kreiraj novog kupca
        $noviKorisnik = Korisnik::create([
            'ime' => $request->ime,
            'prezime' => $request->prezime,
            'email' => $request->email,
            'lozinka' => $request->lozinka,  // Čuva se kao običan tekst
            'tip_korisnika' => 'kupac',
            'telefon' => $request->telefon,
            'adresa' => $request->adresa,
        ]);

        // Automatski prijavi korisnika nakon registracije
        Auth::login($noviKorisnik);

        return redirect()
            ->route('home')
            ->with('success', 'Uspešno ste se registrovali!');
    }
}
