<?php

namespace App\Http\Requests\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;

/** @property-read Blog $blog */
class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->blog);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:3', 'unique:blogs'],
            'description' => ['nullable', 'string', 'min:8', 'max:255'],
            'is_public' => ['nullable', 'boolean']
        ];
    }
}
