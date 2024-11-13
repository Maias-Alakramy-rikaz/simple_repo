<?php

namespace App\Policies;

use App\Models\User;

class ImporterPolicy
{
    /**
     * Create a new policy instance.
     */
    public function block(User $user): bool
    {
        return $user->hasPermissionTo('block');
    }
}
