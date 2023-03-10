<?php

namespace App\Http\Controllers;

use App\Enums\ArchiveBlogAction;
use App\Enums\UserRole;
use App\Events\ArchiveBlogEvent;
use App\Http\Requests\Blog\DeleteBlogRequest;
use App\Http\Requests\Blog\RestoreBlogRequest;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $blogsCollection = Blog::query()
            ->search($request->all())
            ->with('author')
            ->paginate()
        ;

        return BlogResource::collection($blogsCollection);
    }

    public function store(StoreBlogRequest $request): BlogResource|JsonResponse
    {
        $authUser = $request->user();

        if ($authUser->blogs()->count() === 0) {
            $blog = $authUser->blogs()->create($request->validated());

            $authUser->update(['role' => UserRole::Blogger]);
            $blog->load(['author']);

            return new BlogResource($blog);
        }

        return response()->json([
            'message' => 'User can have only one blog!',
        ], 400);
    }

    public function show(Request $request, string $blogId): BlogResource
    {
        $blog = Blog::query()->where('id', $blogId)->with('author')->first();

        return new BlogResource($blog);
    }

    public function update(UpdateBlogRequest $request, Blog $blog): BlogResource
    {
        $blog->update($request->all());
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function destroy(DeleteBlogRequest $request, Blog $blog): JsonResponse
    {
        $blog->delete();

        event(new ArchiveBlogEvent($blog, ArchiveBlogAction::Delete));

        return response()->json([
            'message' => 'Blog has been successfully deleted'
        ]);
    }

    public function restore(RestoreBlogRequest $request, Blog $blog): BlogResource
    {
        $blog->restore();

        event(new ArchiveBlogEvent($blog, ArchiveBlogAction::Recover));

        return new BlogResource($blog);
    }
}
