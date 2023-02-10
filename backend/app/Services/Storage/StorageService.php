<?php
declare(strict_types=1);

namespace App\Services\Storage;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

abstract class StorageService
{
    public const AVATARS_FOLDER = 'avatars';
    public const POSTS_FOLDER = 'posts';

    public static function put(string $path, string|Image $file, string $visibility = 'public'): string|bool
    {
        Storage::put(
            $path,
            $file,
            ['visibility' => $visibility]
        );

        return Storage::url($path);
    }

    public static function delete(array|string $paths): bool
    {
        return Storage::delete($paths);
    }

    public static function exists(string $path): bool
    {
        return Storage::exists($path);
    }
}
