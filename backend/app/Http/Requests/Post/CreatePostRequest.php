<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Post::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'text' => ['required', 'text', 'min:8'],
            'categories_ids' => ['required', 'array'],
            'categories_ids.*' => Rule::forEach(function () {
                return [
                    Rule::exists(Category::class, 'id')
                ];
            }),
            'images' => ['sometimes'],
        ];
    }
}
