<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Blog $blog): bool
    {
        return $blog->isOwnedBy($user);
    }

    public function delete(User $user, Blog $blog): bool
    {
        return $blog->isOwnedBy($user);
    }

    public function restore(User $user, Blog $blog): bool
    {
        return $blog->isOwnedBy($user);
    }
}
