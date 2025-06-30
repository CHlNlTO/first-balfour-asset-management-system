<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CostCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class CostCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_cost::code');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CostCode $costCode): bool
    {
        return $user->can('view_cost::code');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_cost::code');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CostCode $costCode): bool
    {
        return $user->can('update_cost::code');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CostCode $costCode): bool
    {
        return $user->can('delete_cost::code');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_cost::code');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CostCode $costCode): bool
    {
        return $user->can('force_delete_cost::code');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_cost::code');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CostCode $costCode): bool
    {
        return $user->can('restore_cost::code');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_cost::code');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CostCode $costCode): bool
    {
        return $user->can('replicate_cost::code');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_cost::code');
    }
}
