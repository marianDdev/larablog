<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function validateLogin(LoginRequest $request): bool
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return false;
        }

        return true;
    }
}
