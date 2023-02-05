<?php
declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\AvatarsUploadServiceInterface;
use App\Services\Contracts\GeneratorFileNameInterface;

class AvatarsService implements AvatarsUploadServiceInterface, GeneratorFileNameInterface
{
    private const AVATARS_FOLDER = 'avatars';

    public function storeAvatar(string $base64Data): string
    {
        $path = self::AVATARS_FOLDER . DIRECTORY_SEPARATOR . $this->generateFileName();

        return (new StorageService())->storeFile($path, $base64Data);
    }

    public function generateFileName(): string
    {
        return uniqid('img_', true) . '.jpg';
    }
}
