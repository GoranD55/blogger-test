<?php
declare(strict_types=1);

namespace App\Services\Contracts;

interface GeneratorFileNameInterface
{
    public function generateFileName(): string;
}