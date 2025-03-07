<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function list(): PostResourceCollection
    {
        $posts = Post::all();

        return new PostResourceCollection($posts);
    }

    public function getPost(int $id): JsonResource
    {
        try {
            $post = Post::findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorResource([
                                         'code'    => 404,
                                         'message' => 'Resource not found',
                                     ]);
        }

        return new PostResource($post);
    }

    public function createPost(StorePostRequest $request): JsonResource
    {
        $validated = $request->validated();

        $post = Post::create($validated);

        return new PostResource($post);
    }

    public function updatePost(UpdatePostRequest $request, int $id): JsonResource
    {
        $validated = $request->validated();

        $post = Post::findOrFail($id);
        $post->update($validated);

        return new PostResource($post);
    }

    public function deletePost(int $id): JsonResource
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostResource($post);
    }
}
