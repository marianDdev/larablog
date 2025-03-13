<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(
        RegisterRequest      $request,
        UserServiceInterface $userService
    ): AuthResource
    {
        $validated = $request->validated();

        return new AuthResource($userService->createUser($validated));
    }

    public function login(
        LoginRequest         $request,
        AuthServiceInterface $authService,
        UserServiceInterface $userService
    ): AuthResource|JsonResponse
    {
        $validated = $request->validated();
        if (!$authService->validateLogin($request)) {
            return new JsonResponse(
                [
                    'message' => 'Invalid credentials',
                ],
                401
            );
        }

        return new AuthResource($userService->getUserWithToken($validated));
    }
}
