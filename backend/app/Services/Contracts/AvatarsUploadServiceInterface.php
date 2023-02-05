<?php
declare(strict_types=1);

namespace App\Services\Contracts;

interface AvatarsUploadServiceInterface
{
    public function storeAvatar(string $base64Data): string;
}
