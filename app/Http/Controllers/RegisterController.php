<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user      = User::create($validated);
        $role      = Role::firstOrCreate(['name' => $validated['role']]);
        $user->assignRole($role);
        $token     = $user->createToken('auth_token')->plainTextToken;

        return new UserResource([
                                    'user'        => $user,
                                    'accessToken' => $token,
                                    'token_type'  => 'Bearer',
                                ]);
    }
}
