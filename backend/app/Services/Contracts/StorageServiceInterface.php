<?php
declare(strict_types=1);

namespace App\Services\Contracts;

interface StorageServiceInterface
{
    public function storeFile(string $path, string $base64Data): string;
}
