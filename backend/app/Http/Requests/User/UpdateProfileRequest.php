<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string', 'min:3', 'max:50'],
            'last_name' => ['sometimes', 'string', 'min:3', 'max:50'],
            'email' => ['sometimes', 'email', 'unique:users'],
            'avatar' => ['sometimes', 'image'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
