<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff'], true);
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'staff') {
            return (int) $student->consultant_user_id === (int) $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff'], true);
    }

    public function update(User $user, Student $student): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'staff') {
            return (int) $student->consultant_user_id === (int) $user->id;
        }

        return false;
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->role === 'admin';
    }
}