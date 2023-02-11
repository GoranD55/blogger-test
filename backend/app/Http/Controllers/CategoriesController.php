<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\IndexCategoriesRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{
    public function index(IndexCategoriesRequest $request): AnonymousResourceCollection
    {
        $categories = cache()->sear('categories', function () {
            return Category::query()->get();
        });

        return CategoryResource::collection($categories);
    }
}
