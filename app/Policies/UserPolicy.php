<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function block(User $user) {
        return $user->hasPermissionTo('block');
    }
}
