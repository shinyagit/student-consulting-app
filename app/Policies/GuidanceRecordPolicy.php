<?php

namespace App\Policies;

use App\Models\GuidanceRecord;
use App\Models\User;

class GuidanceRecordPolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff'], true);
    }

    public function view(User $user, GuidanceRecord $guidanceRecord): bool
    {
        return in_array($user->role, ['admin', 'staff'], true);
    }

    public function update(User $user, GuidanceRecord $guidanceRecord): bool
    {
        return in_array($user->role, ['admin', 'staff'], true);
    }

    public function delete(User $user, GuidanceRecord $guidanceRecord): bool
    {
        return $user->role === 'admin';
    }
}