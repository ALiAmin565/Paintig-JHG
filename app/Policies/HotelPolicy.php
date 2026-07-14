<?php

namespace App\Policies;

use App\Models\Hotel;
use App\Models\User;

class HotelPolicy
{
    /**
     * Determine whether the user can view any hotels.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    /**
     * Determine whether the user can view the hotel.
     */
    public function view(User $user, Hotel $hotel): bool
    {
        return $user->isActive();
    }

    /**
     * Determine whether the user can create hotels.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    /**
     * Determine whether the user can update the hotel.
     */
    public function update(User $user, Hotel $hotel): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    /**
     * Determine whether the user can delete the hotel.
     */
    public function delete(User $user, Hotel $hotel): bool
    {
        // Prevent deletion if hotel has paintings
        if ($hotel->paintings()->count() > 0) {
            return false;
        }

        return $user->isAdmin() && $user->isActive();
    }

    /**
     * Determine whether the user can restore the hotel.
     */
    public function restore(User $user, Hotel $hotel): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     */
    public function forceDelete(User $user, Hotel $hotel): bool
    {
        return $user->isAdmin() && $user->isActive();
    }
}