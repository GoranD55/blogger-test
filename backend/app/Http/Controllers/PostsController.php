<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Resources\PostResource;

class PostsController extends Controller
{
    public function store(CreatePostRequest $request): PostResource
    {

    }
}
