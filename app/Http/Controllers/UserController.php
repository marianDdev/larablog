<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Services\UserServiceInterface;

class UserController extends Controller
{
    public function getUsers(UserServiceInterface $userService): UserResourceCollection
    {
        return new UserResourceCollection($userService->getUsers());
    }

    public function getUser(UserServiceInterface $userService, int $id): UserResource
    {
        return new UserResource($userService->getUser('id', $id));
    }
}
