<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;

class BlogSubscribersController extends Controller
{
    public function subscribe(Blog $blog): JsonResponse
    {
        if ($blog->subscribers()->wherePivot('user_id', auth()->id())->exists()) {
            return response()->json([
                'message' => 'You have already subscribed to this blog'
            ], 400);
        }

        $blog->subscribers()->attach(auth()->id());

        return response()->json([
            'message' => 'Successfully subscribed'
        ]);
    }

    public function unsubscribe(Blog $blog): JsonResponse
    {
        $blog->subscribers()->detach(auth()->id());

        return response()->json([
            'message' => 'Successfully unsubscribed'
        ]);
    }
}
