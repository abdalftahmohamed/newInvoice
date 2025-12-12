<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Request;

class AuthService
{
    public $authRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository();
    }
    public function login(array $credentials, string $guard, bool $remember = false): array
    {
        return $this->authRepository->login($credentials, $guard, $remember);
    }

    public function logout($gaurd)
    {
        $this->authRepository->logout($gaurd);
    }
}
