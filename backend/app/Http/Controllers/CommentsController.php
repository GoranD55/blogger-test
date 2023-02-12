<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\IndexCommentsRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentsController extends Controller
{
    public function index(IndexCommentsRequest $request, Post $post): AnonymousResourceCollection
    {
        return CommentResource::collection($post->comments()->whereNull('parent_id')->with(['user', 'comments'])->get());
    }

    public function store(CreateCommentRequest $request, Post $post): CommentResource
    {
        $requestData = $request->validated();

        $comment = $post->comments()->create(array_merge(
            $requestData,
            [
                'user_id' => auth()->id()
            ]
        ));

        return new CommentResource($comment);
    }
}
