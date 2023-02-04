<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request): UserResource
    {
        $userData = $request->validated();
        $userData['password'] = Hash::make($userData['password']);

        $user = User::query()->create($userData);

        return new UserResource($user);
    }

    public function authenticate(LoginRequest $request): JsonResponse
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

    public function logout(Request $request): JsonResponse
    {
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json();
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $resetPasswordLinkResponseStatus = Password::sendResetLink(
            $request->only('email')
        );

        if ($resetPasswordLinkResponseStatus === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Reset password link was sent to your email',
            ]);
        }

        return response()->json([
            'message' => 'Something went wrong',
            'error' => $resetPasswordLinkResponseStatus
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
    }
}
