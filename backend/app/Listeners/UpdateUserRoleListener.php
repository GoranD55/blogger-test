<?php

namespace App\Listeners;

use App\Enums\ArchiveBlogAction;
use App\Enums\UserRole;
use App\Events\ArchiveBlogEvent;

class UpdateUserRoleListener
{
    public function handle(ArchiveBlogEvent $archiveBlogEvent): void
    {
        $blog = $archiveBlogEvent->getBlog();

        if ($archiveBlogEvent->getAction() === ArchiveBlogAction::Delete) {
            $blog->author()->update(['role' => UserRole::Reader]);
        }

        if ($archiveBlogEvent->getAction() === ArchiveBlogAction::Recover) {
            $blog->author()->update(['role' => UserRole::Blogger]);
        }
    }
}
