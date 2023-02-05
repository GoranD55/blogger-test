<?php
namespace App\Models\Traits;

use App\Models\User;

trait IsOwnedByTrait
{
    public function isOwnedBy(User $user) : bool
    {
        return $this->user_id === $user->id;
    }
}
