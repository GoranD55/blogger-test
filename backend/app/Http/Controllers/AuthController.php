<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request): UserResponse
    {
        $userData = $request->validated();
        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        return new UserResponse($user);
    }

    //LoginRequest
    public function authenticate(Request $request)
    {
        $request->session()->regenerateToken();

        $isAuthenticated = Auth::attempt(
            $request->only(['email', 'password']),
            $request->input('remember')
        );

        if ($isAuthenticated) {
            return response()->json([
                'message' => 'Logged successfully'
            ]);
        }

        return response()->json([
            'message' => ' Credentials is wrong'
        ], 401);
    }
}
