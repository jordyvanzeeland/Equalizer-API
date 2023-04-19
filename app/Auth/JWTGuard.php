<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTGuard as BaseJWTGuard;

class JWTGuard extends BaseJWTGuard implements Guard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider, Request $request)
    {
        parent::__construct($provider, $request);
    }

    public function attempt(array $credentials = [], $login = true)
    {
        // Implement the attempt() method with the same signature as in the
        // Tymon\JWTAuth\JWTGuard class, e.g.:
        return parent::attempt($credentials, $login);
    }

    public function user()
    {
        // Implement the user() method if needed, e.g.:
        if (! is_null($this->user)) {
            return $this->user;
        }

        if ($id = $this->getTokenForRequest()) {
            $this->user = $this->provider->retrieveById($id);
        }

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        // Implement the validate() method if needed, e.g.:
        $user = $this->provider->retrieveByCredentials($credentials);
        if ($user && $this->provider->validateCredentials($user, $credentials)) {
            return $user;
        }

        return false;
    }
}
