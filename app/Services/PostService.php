<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Horizon\Exceptions\ForbiddenException;

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
        /** @var User $user */
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if ($user->cannot('update', $post)) {
            throw new ForbiddenException(403, 'You are not allowed to update this post');
        }

        $post->update($data);

        return $post;
    }

    public function deletePost(int $id): void
    {
        /** @var User $user */
        $user = Auth::user();

        $post = Post::findOrFail($id);

        if ($user->cannot('update', $post)) {
            throw new ForbiddenException(403, 'You are not allowed to delete this post');
        }

        $post->delete($post);
    }
}
