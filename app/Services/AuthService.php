<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials, bool $remember = false): bool
    {
        unset($credentials['remember']);
        return Auth::attempt($credentials, $remember);
    }
    
    public function logout(): void
    {
        Auth::logout();
    }
}