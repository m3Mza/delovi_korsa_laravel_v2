<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Korisnik;

/**
 * Login Controller
 * 
 * Kontroler za autentifikaciju korisnika - prijava i odjava.
 */
class LoginController extends Controller
{
    /**
     * Prikaži formu za prijavu
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Admin korisnici se redirektuju na admin panel, kupci na početnu stranicu.
     */
    public function login(Request $request)
    {
        // Validacija unetih podataka
        $credentials = $request->validate([
            'email' => 'required|email',
            'lozinka' => 'required|string',
        ]);

        // Pronađi korisnika po email adresi
        $korisnik = Korisnik::where('email', $credentials['email'])->first();
        
        // Proveri da li korisnik postoji
        if (!$korisnik) {
            return back()->withErrors([
                'email' => 'Korisnik sa ovim email-om ne postoji.',
            ])->onlyInput('email');
        }

        // Proveri lozinku (običan tekst, ne hash)
        if ($korisnik->lozinka !== $credentials['lozinka']) {
            return back()->withErrors([
                'email' => 'Neispravna lozinka.',
            ])->onlyInput('email');
        }

        // Prijavi korisnika u sistem
        Auth::login($korisnik);
        $request->session()->regenerate();

        // Redirektuj u zavisnosti od tipa korisnika
        if ($korisnik->isAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Dobrodošli, Admin!');
        }

        return redirect()
            ->route('home')
            ->with('success', 'Uspešno ste se prijavili!');
    }

    /**
     * Odjavi korisnika iz sistema
     */
    public function logout(Request $request)
    {
        // Odjavi korisnika
        Auth::logout();
        
        // Poništi sesiju 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Uspešno ste se odjavili!');
    }
}
