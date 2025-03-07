<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user      = User::where('email', $validated['email'])->first();

        if (is_null($user)) {
            return new ErrorResource(['message' => 'User not found']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return new UserResource([
                                    'user'        => $user,
                                    'accessToken' => $token,
                                    'token_type'  => 'Bearer',
                                ]);
    }
}
