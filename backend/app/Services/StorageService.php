<?php
declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\StorageServiceInterface;
use Illuminate\Support\Facades\Storage;

class StorageService implements StorageServiceInterface
{
    public function storeFile(string $path, string $base64Data): string
    {
        Storage::put($path, file_get_contents($base64Data), [
            'visibility' => 'public'
        ]);

        return Storage::url($path);
    }
}
