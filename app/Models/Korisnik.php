<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model Korisnik
 */
class Korisnik extends Authenticatable
{
    use HasFactory, Notifiable;

    // Naziv tabele u bazi podataka
    protected $table = 'korisnici';

    // Omogući automatsko generisanje created_at i updated_at timestamp-ova
    public $timestamps = true;

    // Polja koja se mogu masovno popunjavati (mass assignment)
    protected $fillable = [
        'ime',
        'prezime',
        'email',
        'lozinka',
        'tip_korisnika',  // 'admin' ili 'kupac'
        'telefon',
        'adresa',
    ];

    // Lozinka skrivena pri eksportu u JSON
    protected $hidden = [
        'lozinka',
    ];

    /**
     * Vrati naziv kolone za lozinku u bazi
     * 
     * Laravel po defaultu koristi 'password', ali mi koristimo 'lozinka'
     */
    public function getAuthPasswordName()
    {
        return 'lozinka';
    }

    /**
     * Vrati vrednost lozinke za autentifikaciju
     */
    public function getAuthPassword()
    {
        return $this->lozinka;
    }

    /**
     * Spreči Laravel da postavlja vrednost u 'password' kolonu
     * 
     * Ova metoda presreće pokušaj postavljanja 'password' atributa
     * i sprečava grešku jer ta kolona ne postoji u bazi.
     */
    public function setAttribute($key, $value)
    {
        // Ignoriši pokušaj postavljanja 'password' polja
        if ($key === 'password') {
            return $this;
        }
        
        // Za 'lozinka' polje, sačuvaj običan tekst bez hash-ovanja
        if ($key === 'lozinka') {
            $this->attributes['lozinka'] = $value;
            return $this;
        }
        
        return parent::setAttribute($key, $value);
    }

    /**
     * Proveri da li je korisnik admin
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->tip_korisnika === 'admin';
    }

    /**
     * Proveri da li je korisnik kupac
     * 
     * @return bool
     */
    public function isKupac()
    {
        return $this->tip_korisnika === 'kupac';
    }

    /**
     * Relacija: Proizvodi koji su na korisnikovoj listi želja
     * 
     * Many-to-Many relacija sa Proizvod modelom preko 'wishlist' tabele
     */
    public function wishlist()
    {
        return $this->belongsToMany(Proizvod::class, 'wishlist', 'korisnik_id', 'proizvod_id');
    }
}
