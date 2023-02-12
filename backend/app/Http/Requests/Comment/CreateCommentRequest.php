<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

/** @property-read Post $post */
class CreateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', [Comment::class, $this->post]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'min:2', 'max:255'],
            'parent_id' => ['sometimes', 'nullable', 'int', 'exists:comments'],
        ];
    }
}
