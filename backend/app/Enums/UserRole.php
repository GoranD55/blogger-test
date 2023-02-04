<?php
declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Reader = 'reader';
    case Blogger = 'blogger';
}
