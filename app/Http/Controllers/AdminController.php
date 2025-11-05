<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Admin Controller
 * 
 * Kontroler za administratorski panel - upravljanje proizvodima u prodavnici.
 * Sve metode zahtevaju da korisnik bude prijavljen i ima admin privilegije.
 */
class AdminController extends Controller
{
    /**
     * Prikaži admin dashboard sa listom svih proizvoda
     */
    public function dashboard()
    {
        // Proveri da li je korisnik prijavljen i da li je admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        // Učitaj sve proizvode iz baze
        $proizvodi = Proizvod::all();
        
        return view('admin.dashboard', compact('proizvodi'));
    }

    /**
     * Prikaži formu za kreiranje novog proizvoda
     */
    public function create()
    {
        // Proveri admin pristup
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        return view('admin.create');
    }

    /**
     * Sačuvaj novi proizvod u bazu podataka
     */
    public function store(Request $request)
    {
        // Proveri admin pristup
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        // Validacija unetih podataka
        $validiraniPodaci = $request->validate([
            'name' => 'required|string|max:255',      // Naziv je obavezan
            'price' => 'required|numeric|min:0',       // Cena mora biti pozitivan broj
            'image' => 'nullable|string|max:255',      // URL slike je opcioni
            'category' => 'nullable|string|max:100',   // Kategorija je opciona
            'brand' => 'nullable|string|max:100',      // Brend je opcioni
        ]);

        // Kreiraj novi proizvod u bazi
        Proizvod::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            'category' => $request->category,
            'brand' => $request->brand,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Proizvod uspešno dodat!');
    }

    /**
     * Prikaži formu za izmenu postojećeg proizvoda
     */
    public function edit($id)
    {
        // Proveri admin pristup
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        // Pronađi proizvod po ID-u ili prikaži grešku
        $proizvod = Proizvod::findOrFail($id);
        
        return view('admin.edit', compact('proizvod'));
    }

    /**
     * Ažuriraj postojeći proizvod u bazi
     */
    public function update(Request $request, $id)
    {
        // Proveri admin pristup
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        // Validacija unetih podataka
        $validiraniPodaci = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
        ]);

        // Pronađi proizvod
        $proizvod = Proizvod::findOrFail($id);
        
        // Ažuriraj podatke proizvoda
        $proizvod->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            'category' => $request->category,
            'brand' => $request->brand,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Proizvod uspešno ažuriran!');
    }

    /**
     * Obriši proizvod iz baze
     */
    public function destroy($id)
    {
        // Proveri admin pristup
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }

        // Pronađi i obriši proizvod
        $proizvod = Proizvod::findOrFail($id);
        $proizvod->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Proizvod uspešno obrisan!');
    }
}
