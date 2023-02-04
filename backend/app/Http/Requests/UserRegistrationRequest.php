<?php

namespace App\Http\Requests;

use App\Exceptions\Hello;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'string|min:3|max:50',
            'last_name' => 'string|min:3|max:50',
            'email' => 'string|email|unique:users',
            'password' => 'string',
        ];
    }
}
