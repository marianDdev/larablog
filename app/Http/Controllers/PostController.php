<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Services\PostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct(private readonly PostServiceInterface $postService)
    {
    }

    public function getPosts(): PostResourceCollection
    {
        return new PostResourceCollection($this->postService->getPosts());
    }

    public function getPost(int $id): JsonResource|JsonResponse
    {
        $post = $this->postService->getPost($id);

        if (is_null($post)) {
            return new JsonResponse(
                ['error' => 'Post not found'],
                404,
            );
        }

        return new PostResource($post);
    }

    public function createPost(StorePostRequest $request): JsonResource|JsonResponse
    {
        $validated            = $request->validated();
        $validated['user_id'] = auth()->id();

        try {
            $post = $this->postService->createPost($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return new JsonResponse(
                ['error' => 'something went wrong'],
                $e->getCode(),
            );
        }

        return new PostResource($post);
    }

    public function updatePost(UpdatePostRequest $request, int $id): PostResource|JsonResponse
    {
        $validated = $request->validated();

        try {
            $post = $this->postService->updatePost($validated, $id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return new JsonResponse(
                ['error' => 'something went wrong'],
                $e->getCode(),
            );
        }

        return new PostResource($post);
    }

    public function deletePost(int $id): JsonResponse
    {
        try {
            $this->postService->deletePost($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return new JsonResponse(
                ['error' => 'something went wrong'],
                $e->getCode(),
            );
        }

        return new JsonResponse(null, 204);
    }
}
