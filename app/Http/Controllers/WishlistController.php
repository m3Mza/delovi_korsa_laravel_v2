<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    // Add product to wishlist
    public function add($proizvodId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Morate biti prijavljeni da biste dodali proizvod u listu želja.');
        }

        $korisnik = Auth::user();
        
        // Check if already in wishlist
        $exists = DB::table('wishlist')
            ->where('korisnik_id', $korisnik->id)
            ->where('proizvod_id', $proizvodId)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Proizvod je već u listi želja.');
        }

        // Add to wishlist
        DB::table('wishlist')->insert([
            'korisnik_id' => $korisnik->id,
            'proizvod_id' => $proizvodId,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Proizvod dodat u listu želja!');
    }

    // Remove product from wishlist
    public function remove($proizvodId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        DB::table('wishlist')
            ->where('korisnik_id', Auth::id())
            ->where('proizvod_id', $proizvodId)
            ->delete();

        return back()->with('success', 'Proizvod uklonjen iz liste želja!');
    }

    // Show user's wishlist
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Morate biti prijavljeni.');
        }

        $wishlist = Auth::user()->wishlist;

        return view('wishlist.index', compact('wishlist'));
    }
}
