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
        return CategoryResource::collection(Category::query()->get());
    }
}
