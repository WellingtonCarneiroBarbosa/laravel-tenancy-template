<?php

namespace App\Policies\Application;

use App\Models\Application\User as Student;
use App\Models\User;

class StudentsPolicy
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
    public function view(User $user, Student $model): bool
    {
        return tenant('id') == $user->current_team_id
            && $model->getConnection()->getDatabaseName() == tenant('tenancy_db_name');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return tenant('id') == $user->current_team_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $model): bool
    {
        return tenant('id') == $user->current_team_id
            && $model->getConnection()->getDatabaseName() == tenant('tenancy_db_name');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $model): bool
    {
        return tenant('id') == $user->current_team_id
            && $model->getConnection()->getDatabaseName() == tenant('tenancy_db_name');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Student $model): bool
    {
        return tenant('id') == $user->current_team_id
            && $model->getConnection()->getDatabaseName() == tenant('tenancy_db_name');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $model): bool
    {
        return tenant('id') == $user->current_team_id
            && $model->getConnection()->getDatabaseName() == tenant('tenancy_db_name');
    }
}
