<?php
declare(strict_types=1);

namespace App\Services;

use App\Services\Storage\FileUploadService;
use App\Services\Storage\StorageService;

class UserService
{
    /**
     * @throws \App\Exceptions\FailedConvertImageFromBase64Exception
     * @throws \ErrorException
     */
    public function uploadUserAvatar(string $base64Data): string|bool
    {
        $fileUploadService = new FileUploadService();

        return $fileUploadService->uploadBase64Image(
            $base64Data,
            StorageService::AVATARS_FOLDER
        );
    }
}
