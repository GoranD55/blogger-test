<?php
declare(strict_types=1);

namespace App\Services\Storage;

use App\Exceptions\FailedConvertImageFromBase64Exception;
use ErrorException;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * @throws FailedConvertImageFromBase64Exception|ErrorException
     */
    public function uploadBase64Image(string $base64Data, string $folder): string|bool
    {
        $imageContent = file_get_contents($base64Data);

        if (!$imageContent) {
            throw new FailedConvertImageFromBase64Exception();
        }

        return StorageService::put(
            $folder . DIRECTORY_SEPARATOR . $this->generateFileName('jpg'),
            $imageContent
        );
    }

    private function generateFileName(string $extension): string
    {
        return Str::random() . '.' . $extension;
    }
}
