<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $userData): UserResource;
    public function getUser(string $criteria, mixed $value): ?User;
    public function getUserWithToken(array $userData): UserResource;
}
