<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewBlogComments(User $user, Post $post): bool
    {
        //todo: if blog is private check that user is subscriber of post blog
        return true;
    }

    public function create(User $user, Post $post): bool
    {
        //tod: check that user is subscriber of post blog
        return true;
    }
}
