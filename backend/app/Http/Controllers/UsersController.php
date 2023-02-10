<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedConvertImageFromBase64Exception;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(Request $request): UserResource
    {
        $profile = $request->user()->load('blog');

        return new UserResource($profile);
    }

    public function updateProfile(
        UpdateProfileRequest $request,
    ): UserResource|JsonResponse {
        $requestData = $request->validated();

        if (isset($requestData['avatar']) && !empty($requestData['avatar'])) {
            try {
                $avatarPath = $this->userService->uploadUserAvatar($requestData['avatar']);

                if (!is_bool($avatarPath)) {
                    $requestData['avatar'] = $avatarPath;
                }

            } catch (FailedConvertImageFromBase64Exception|ErrorException) {
                Log::error(
                    'Cannot upload user avatar',
                    [
                        'exception' => 'Failed to open stream: Bad base64 format',
                    ]
                );

                return response()->json([
                    'message' => 'Cannot upload image file!',
                    'error' => 'Failed to convert file from base 64 format'
                ], 400);
            }
        }

        if (isset($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        }

        $authUser = $request->user();

        $authUser->update($requestData);

        return new UserResource($authUser);
    }
}
