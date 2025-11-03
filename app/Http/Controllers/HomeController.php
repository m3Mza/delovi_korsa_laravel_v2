<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BazaController;

class HomeController extends Controller
{
    protected $baza;

    public function __construct(BazaController $baza)
    {
        $this->baza = $baza;
    }

    public function index()
    {
        // Dobij nasumične proizvode preko BazaController
        $featuredProducts = $this->baza->izdvojeniProizvodi()->original;
        return view('home', compact('featuredProducts'));
    }

    public function about()
    {
        return view('onama');
    }

    public function products()
    {
        $products = $this->baza->sviProizvodi()->original;
        $categories = ['Sve', 'Motor', 'Kočnice', 'Transmisija', 'Elektrika', 'Filteri'];

        return view('proizvodi', compact('products', 'categories'));
    }

public function korpa()
{
    $cartItems = session('cart', []);

    $subtotal = array_sum(array_map(function ($item) {
        // Konverter za korpu
        $price = (float) preg_replace('/[^0-9.]/', '', $item['price']);
        return $price * ($item['quantity'] ?? 1);
    }, $cartItems));

    $total = $subtotal;

    return view('korpa', compact('cartItems', 'subtotal', 'total'));
}



}
