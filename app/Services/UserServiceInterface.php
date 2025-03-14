<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public const string ROLE_ADMIN = 'admin';
    public const string ROLE_AUTHOR = 'author';
    public const string ROLE_READER = 'reader';

    public function createUser(array $userData): array;
    public function getUser(string $criteria, mixed $value): ?User;
    public function getUserWithToken(array $userData): array;
    public function getUsersPaginated(): LengthAwarePaginator;
    public function getUsersByRole(string $role): Collection;
}
