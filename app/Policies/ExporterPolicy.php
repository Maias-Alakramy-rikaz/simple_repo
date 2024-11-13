<?php

namespace App\Policies;

use App\Models\Exporter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExporterPolicy
{
    public function block(User $user): bool
    {
        return $user->hasPermissionTo('block');
    }
}
