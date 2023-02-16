<?php
declare(strict_types=1);

namespace App\Services\Storage;

use App\Exceptions\FailedUploadImageException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadImage(UploadedFile $image, string $folder, ?string $disk = 'public'): string
    {
        $filePath = Storage::disk($disk)->putFile(
            $folder,
            $image
        );

        if (!$filePath) {
            throw new FailedUploadImageException();
        }

        return DIRECTORY_SEPARATOR . $filePath;
    }
}
