<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AvatarsService;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function profile(Request $request): UserResource
    {
        $profile = $request->user()->load([
            'blogs' => function (HasMany $relation) {
                $relation->withTrashed()->latest();
            }
        ]);

        $profile->blogs = $profile->blogs->first();

        return new UserResource($profile);
    }

    public function updateProfile(UpdateProfileRequest $request): UserResource|JsonResponse
    {
        $requestData = $request->validated();

        if (isset($requestData['avatar']) && !empty($requestData['avatar'])) {
            try {
                $avatarsService = new AvatarsService();
                $requestData['avatar'] = $avatarsService->storeAvatar($request->validated()['avatar']);
            } catch (Exception $exception) {
                Log::error(
                    'Cannot upload user avatar',
                    [
                        'exception' => $exception->getMessage(),
                    ]
                );

                return response()->json([
                    'message' => 'Cannot upload image file!',
                    'error' => $exception->getMessage()
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
