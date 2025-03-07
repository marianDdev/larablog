<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{
    public function createUser(array $userData): UserResource
    {
        $user = User::create($userData);
        $role = Role::firstOrCreate(['name' => $userData['role']]);
        $user->assignRole($role);
        $token = $user->createToken('auth_token')->plainTextToken;

        return new UserResource(
            [
                'user'        => $user,
                'accessToken' => $token,
                'token_type'  => 'Bearer',
            ]
        );
    }

    public function getUser(string $criteria, mixed $value): ?User
    {
        return User::where($criteria, $value)->first();
    }

    public function getUserWithToken(array $userData): UserResource
    {
        $user  = $this->getUser('email', $userData['email']);
        $token = $user->createToken('auth_token')->plainTextToken;

        return new UserResource(
            [
                'user'        => $user,
                'accessToken' => $token,
                'token_type'  => 'Bearer',
            ]
        );
    }
}
