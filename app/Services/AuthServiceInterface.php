<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

interface AuthServiceInterface
{
    public function validateLogin(LoginRequest $request): bool;
}
