<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BazaController extends Controller
{
    // Dohvata sve proizvode iz tabele "proizvodi"
    public function sviProizvodi()
    {
        $proizvodi = DB::table('proizvodi')->get();
        return response()->json($proizvodi);
    }

    // Dohvata nasumično izdvojene proizvode iz "proizvodi" tabele
    public function izdvojeniProizvodi()
    {
        $featured = DB::table('proizvodi')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return response()->json($featured);
    }

    // Dohvata jedan proizvod po ID-u
    public function proizvod($id)
    {
        $proizvod = DB::table('proizvodi')->where('id', $id)->first();
        return response()->json($proizvod);
    }
}
