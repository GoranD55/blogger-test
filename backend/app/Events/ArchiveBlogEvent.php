<?php

namespace App\Events;

use App\Enums\ArchiveBlogAction;
use App\Models\Blog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class ArchiveBlogEvent
{
    use InteractsWithSockets, SerializesModels;

    private Blog $blog;
    private ArchiveBlogAction $action;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Blog $blog, ArchiveBlogAction $action)
    {
        $this->blog = $blog;
        $this->action = $action;
    }

    public function getAction(): ArchiveBlogAction
    {
        return $this->action;
    }

    public function getBlog(): Blog
    {
        return $this->blog;
    }
}
