<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BazaController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/o-nama', [HomeController::class, 'about'])->name('about');
Route::get('/proizvodi', [HomeController::class, 'products'])->name('products');
Route::get('/korpa', [HomeController::class, 'korpa'])->name('korpa');



Route::get('/baza/proizvodi', [BazaController::class, 'sviProizvodi']);
Route::get('/baza/featured', [BazaController::class, 'izdvojeniProizvodi']);
Route::get('/baza/proizvod/{id}', [BazaController::class, 'proizvod']);


Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
