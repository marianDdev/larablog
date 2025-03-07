<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostService implements PostServiceInterface
{

    /**
     * @return LengthAwarePaginator<Post>
     */
    public function getPosts(): LengthAwarePaginator
    {
        return Post::paginate(20);
    }

    public function getPost(int $id): ?Post
    {
        return Post::find($id);
    }

    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    public function updatePost(array $data, int $id): Post
    {
        $post = Post::findOrFail($id);
        $post->update($data);

        return $post;
    }

    public function deletePost(int $id): void
    {
        $post = Post::findOrFail($id);
        $post->delete($post);
    }
}
