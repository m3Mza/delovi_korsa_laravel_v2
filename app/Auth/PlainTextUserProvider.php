<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Ispravka jer hashovane lozinke malo kvarile program
 */
class PlainTextUserProvider extends EloquentUserProvider
{
    /**
     * 
     * Proverava da li se uneta lozinka u obliku običnog teksta podudara
     * sa lozinkom sačuvanom u bazi podataka.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Proveri oba polja: 'lozinka' (srpski) i 'password' (engleski) jer sam malo mesao engl i srpski -- Mirko
        $unetaLozinka = $credentials['lozinka'] ?? $credentials['password'] ?? null;

        // Ako lozinka nije uneta, vrati false
        if ($unetaLozinka === null) {
            return false;
        }

        // Jednostavna provera - poredi unetu lozinku sa lozinkom iz baze
        return $unetaLozinka === $user->getAuthPassword();
    }
}

