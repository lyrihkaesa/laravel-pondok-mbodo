<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employee $employee): bool
    {
        return $user->can('view Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): bool
    {
        return $user->can('update Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): bool
    {
        return $user->can('delete Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employee $employee): bool
    {
        return $user->can('restore Employee') || $user->can('manage Employee');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->can('force-delete Employee');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force-delete-any Employee');
    }
}
