<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only admins can access these methods
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                abort(403, 'Nemate pristup ovoj stranici.');
            }
            return $next($request);
        });
    }

    // Show admin dashboard
    public function dashboard()
    {
        $proizvodi = Proizvod::all();
        return view('admin.dashboard', compact('proizvodi'));
    }

    // Show create product form
    public function create()
    {
        return view('admin.create');
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'cena' => 'required|numeric|min:0',
            'slika' => 'nullable|string|max:255',
            'kategorija' => 'nullable|string|max:100',
            'stanje' => 'nullable|integer|min:0',
        ]);

        Proizvod::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Proizvod uspešno dodat!');
    }

    // Show edit product form
    public function edit($id)
    {
        $proizvod = Proizvod::findOrFail($id);
        return view('admin.edit', compact('proizvod'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'cena' => 'required|numeric|min:0',
            'slika' => 'nullable|string|max:255',
            'kategorija' => 'nullable|string|max:100',
            'stanje' => 'nullable|integer|min:0',
        ]);

        $proizvod = Proizvod::findOrFail($id);
        $proizvod->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Proizvod uspešno ažuriran!');
    }

    // Delete product
    public function destroy($id)
    {
        $proizvod = Proizvod::findOrFail($id);
        $proizvod->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Proizvod uspešno obrisan!');
    }
}
