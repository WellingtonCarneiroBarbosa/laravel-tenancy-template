<?php

namespace App\Policies\Application;

use App\Models\Application\OnBoardingForm;
use App\Models\User;

class OnBoardingFormPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return tenant('id') == $user->current_team_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OnBoardingForm $onBoardingForm): bool
    {
        return tenant('id') == $user->current_team_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return tenant('id') == $user->current_team_id;
    }

    public function createInitial(User $user): bool
    {
        return OnBoardingForm::whereApplicationId(
            tenant('id')
        )->notExists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OnBoardingForm $onBoardingForm): bool
    {
        $databaseName = $onBoardingForm->getConnection()->getDatabaseName();

        return tenant('tenancy_db_name') == $databaseName;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OnBoardingForm $onBoardingForm): bool
    {
        $databaseName = $onBoardingForm->getConnection()->getDatabaseName();

        return tenant('tenancy_db_name') == $databaseName
            && !in_array($onBoardingForm->cicle, [1, 2]);
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
