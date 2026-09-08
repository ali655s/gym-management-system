<?php

namespace App\Policies;

use App\Models\FranchiseApplication;
use App\Models\User;

class FranchiseApplicationPolicy
{
    /**
     * Determine whether the user can view any franchise applications.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the franchise application.
     */
    public function view(User $user, FranchiseApplication $franchiseApplication): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether anyone can create franchise applications.
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the franchise application.
     * Only admins can modify status / review applications.
     */
    public function update(User $user, FranchiseApplication $franchiseApplication): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the franchise application.
     */
    public function delete(User $user, FranchiseApplication $franchiseApplication): bool
    {
        return $user->isAdmin();
    }
}
