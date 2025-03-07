<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{
    /**
     * @return LengthAwarePaginator<Post>
     */
    public function getPosts(): LengthAwarePaginator;
    public function getPost(int $id): ?Post;
    public function createPost(array $data): Post;
    public function updatePost(array $data, int $id): Post;
    public function deletePost(int $id): void;
}
