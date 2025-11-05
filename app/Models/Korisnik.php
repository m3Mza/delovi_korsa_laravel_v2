<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Korisnik extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'korisnici';

    protected $fillable = [
        'ime',
        'prezime',
        'email',
        'lozinka',
        'tip_korisnika',
        'telefon',
        'adresa',
    ];

    protected $hidden = [
        'lozinka',
    ];

    // Override the default password field
    public function getAuthPassword()
    {
        return $this->lozinka;
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->tip_korisnika === 'admin';
    }

    // Check if user is kupac
    public function isKupac()
    {
        return $this->tip_korisnika === 'kupac';
    }

    // Wishlist relationship
    public function wishlist()
    {
        return $this->belongsToMany(Proizvod::class, 'wishlist', 'korisnik_id', 'proizvod_id')
                    ->withTimestamps();
    }
}
