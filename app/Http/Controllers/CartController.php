<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Dodavanje stavke
   public function add(Request $request)
{
    // Cena je u tabeli varchar, kako ne bi morao to da menjam ovo samo konvertuje
    $price = (int) preg_replace('/[^0-9]/', '', $request->price);

    $cart = session()->get('cart', []);

    // Ako stavka postoji, menja kolicinu stavki
    if(isset($cart[$request->id])) {
        $cart[$request->id]['quantity'] += $request->quantity;
    } else {
        $cart[$request->id] = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $price,
            'category' => $request->category,
            'quantity' => $request->quantity,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Proizvod dodat u korpu!');
}


    // Azuriranje kolicine stavki
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }
        return redirect()->back();
    }

    // Uklanjanje stavki
    public function remove($id)
    {
        $cart = session('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->back();
    }
}
