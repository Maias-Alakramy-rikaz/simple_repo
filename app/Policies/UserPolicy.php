<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function block_exporter(User $user, Exporter $exporter) {
        return $user->can('block');
    }
}
