<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proizvod extends Model
{
    use HasFactory;

    protected $table = 'proizvodi';

    protected $fillable = [
        'naziv',
        'opis',
        'cena',
        'slika',
        'kategorija',
        'stanje',
    ];

    // Wishlist relationship
    public function wishlistedBy()
    {
        return $this->belongsToMany(Korisnik::class, 'wishlist', 'proizvod_id', 'korisnik_id')
                    ->withTimestamps();
    }
}
