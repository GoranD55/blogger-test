<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Services\Storage\FileUploadService;
use App\Services\Storage\StorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * @throws \App\Exceptions\FailedUploadImageException
     * @throws \ErrorException
     */
    public function uploadUserAvatar(User $user, UploadedFile $base64Data): string
    {
        if (!strpos($user->avatar, '/avatars/default.png')) {
            Storage::disk('public')->delete($user->avatar);
        }

        $fileUploadService = new FileUploadService();

        return $fileUploadService->uploadImage(
            $base64Data,
            StorageService::AVATARS_FOLDER
        );
    }
}
