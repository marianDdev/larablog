<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Scopes\IsActive;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{
    public function createUser(array $userData): array
    {
        $user = User::create($userData);
        $role = Role::firstOrCreate(['name' => $userData['role']]);
        $user->assignRole($role);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'        => new UserResource($user),
            'accessToken' => $token,
            'token_type'  => 'Bearer',
        ];
    }

    public function getUser(string $criteria, mixed $value): ?User
    {
        return User::withoutGlobalScope(IsActive::class)->where($criteria, $value)->first();
    }

    public function getUserWithToken(array $userData): array
    {
        $user  = $this->getUser('email', $userData['email']);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'        => new UserResource($user),
            'accessToken' => $token,
            'token_type'  => 'Bearer',
        ];
    }

    public function getUsersPaginated(): LengthAwarePaginator
    {
        return User::paginate(20);
    }

    public function getUsersByRole(string $role): Collection
    {
        return User::role($role)->get();
    }
}
