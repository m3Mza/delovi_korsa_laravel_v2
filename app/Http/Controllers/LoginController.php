<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'lozinka' => 'required|string',
        ]);

        // Attempt to log in
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['lozinka']])) {
            $request->session()->regenerate();

            // Check user type and redirect accordingly
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Dobrodošli, Admin!');
            }

            return redirect()->route('home')->with('success', 'Uspešno ste se prijavili!');
        }

        return back()->withErrors([
            'email' => 'Neispravni podaci za prijavu.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Uspešno ste se odjavili!');
    }
}
