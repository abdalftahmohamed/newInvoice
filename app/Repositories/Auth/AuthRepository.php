<?php

namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Auth;

class AuthRepository
{

    public function login($credentials, $guard, $remember = false)
    {
        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            return [
                'success' => true,
                'user' => Auth::guard($guard)->user(),
            ];
        }

        return [
            'success' => false,
            'user' => null,
        ];
    }

    /**
     * Log the user out.
     *
     * @param string $guard
     * @return void
     */
    public function logout(string $guard): void
    {
        Auth::guard($guard)->logout();
    }
}
