<?php
declare(strict_types=1);

namespace App\Enums;

enum ArchiveBlogAction: string
{
    case Recover = 'recover';
    case Delete = 'delete';
}
