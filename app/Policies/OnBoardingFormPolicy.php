<?php

namespace App\Policies;

use App\Models\Application\OnBoardingForm;
use App\Models\User;

class OnBoardingFormPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return true;
    }
}
