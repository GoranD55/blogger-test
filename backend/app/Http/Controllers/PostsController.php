<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedConvertImageFromBase64Exception;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\DeletePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\Storage\FileUploadService;
use App\Services\Storage\StorageService;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        //todo: make pagination
        return PostResource::collection(Post::query()->paginate(10));
    }

    public function getUserPosts(Request $request, User $user)
    {
        //todo: make pagination
        return PostResource::collection($user->posts()->paginate(10));
    }

    public function store(CreatePostRequest $request): PostResource|JsonResponse
    {
        $requestData = $request->validated();

        $post = Post::query()->create(array_merge(
            $requestData,
            [
                'user_id' => auth()->id(),
                'blog_id' => auth()->user()->blog()->id
            ]
        ));

        if (isset($requestData['images'])) {
            try {
                $fileUploadService = new FileUploadService();
                foreach ($requestData['images'] as $image) {
                    $imagePath = $fileUploadService->uploadBase64Image($image, StorageService::POSTS_FOLDER);
                    //todo: attach to the attachments table with post id
                }
            } catch (FailedConvertImageFromBase64Exception|ErrorException) {
                Log::error(
                    'Cannot upload post image',
                    [
                        'exception' => 'Failed to open stream: Bad base64 format',
                    ]
                );

                return response()->json([
                    'message' => 'Cannot upload image file!',
                    'error' => 'Failed to convert file from base 64 format'
                ], 400);
            }
        }

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $requestData = $request->validated();
        $post->update($requestData);

        //todo: update post images if need

        return new PostResource($post);
    }

    public function destroy(DeletePostRequest $request, string $post_id): JsonResponse
    {
        Post::query()->where('id', $post_id)->delete();

        return response()->json([
            'message' => 'Post has been successfully deleted'
        ]);
    }
}
