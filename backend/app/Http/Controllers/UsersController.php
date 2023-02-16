<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedUploadImageException;
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
        $authUser = $request->user();
        $requestData = $request->validated();

        if ($request->hasFile('avatar')) {
            try {
                $requestData['avatar'] = $this->userService->uploadUserAvatar($authUser, $request->file('avatar'));
            } catch (FailedUploadImageException|ErrorException $exception) {
                Log::error(
                    'Cannot upload user avatar',
                    [
                        'exception' =>  $exception->getMessage(),
                    ]
                );

                return response()->json([
                    'message' => 'Failed upload user avatar',
                ], 400);
            }
        }

        if (isset($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        }

        $authUser->update($requestData);

        return new UserResource($authUser);
    }
}
