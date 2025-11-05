<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Proizvod
 */
class Proizvod extends Model
{
    use HasFactory;

    // Naziv tabele u bazi podataka
    protected $table = 'proizvodi';

    // Isključi automatske timestamp-ove jer tabela nema created_at i updated_at kolone
    public $timestamps = false;

 
    protected $fillable = [
        'name',       // Naziv proizvoda (koristi se u bazi)
        'price',      // Cena proizvoda (koristi se u bazi)
        'image',      // URL slike proizvoda (koristi se u bazi)
        'category',   // Kategorija proizvoda (koristi se u bazi)
        'brand',      // Brend proizvoda (koristi se u bazi)
        
    ];

    /**
     * Relacija: Korisnici koji su dodali ovaj proizvod na listu želja
     * 
     * Many-to-Many relacija sa Korisnik modelom preko 'wishlist' tabele
     */
    public function wishlistedBy()
    {
        return $this->belongsToMany(Korisnik::class, 'wishlist', 'proizvod_id', 'korisnik_id');
    }
}
