<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Wishlist Controller
 */
class WishlistController extends Controller
{
    /**
     * Dodaj proizvod na listu želja
     * 
     * @param int $proizvodId ID proizvoda koji se dodaje
     */
    public function add($proizvodId)
    {
        // Proveri da li je korisnik prijavljen
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Morate biti prijavljeni da biste dodali proizvod u listu želja.');
        }

        $korisnik = Auth::user();
        
        // Proveri da li proizvod već postoji na listi želja
        $postojiNaListi = DB::table('wishlist')
            ->where('korisnik_id', $korisnik->id)
            ->where('proizvod_id', $proizvodId)
            ->exists();

        if ($postojiNaListi) {
            return back()->with('info', 'Proizvod je već u listi želja.');
        }

        // Dodaj proizvod na listu želja
        DB::table('wishlist')->insert([
            'korisnik_id' => $korisnik->id,
            'proizvod_id' => $proizvodId,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Proizvod dodat u listu želja!');
    }

    /**
     * Ukloni proizvod sa liste želja
     * 
     * @param int $proizvodId ID proizvoda koji se uklanja
     */
    public function remove($proizvodId)
    {
        // Proveri da li je korisnik prijavljen
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Obriši proizvod sa liste želja
        DB::table('wishlist')
            ->where('korisnik_id', Auth::id())
            ->where('proizvod_id', $proizvodId)
            ->delete();

        return back()->with('success', 'Proizvod uklonjen iz liste želja!');
    }

    /**
     * Prikaži listu želja korisnika
     * Vraća view sa svim proizvodima koje je korisnik dodao na listu želja.
     */
    public function index()
    {
        // Proveri da li je korisnik prijavljen
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Morate biti prijavljeni.');
        }

        // Učitaj sve proizvode sa liste želja
        $wishlist = Auth::user()->wishlist;

        return view('wishlist.index', compact('wishlist'));
    }
}
