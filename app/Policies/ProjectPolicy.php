<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->role === 'manager' || $user->role === 'admin';
    }

    /**
     * Determine if the user can view the project.
     */
    public function view(User $user, Project $project)
    {
        return $user->role === 'admin' || $project->users->contains($user);
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project)
    {
        return $user->id === $project->user_id || $user->role === 'manager';
    }



    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project)
    {
        return $user->role === 'admin' || $user->id === $project->user_id;
    }


    public function viewAny(User $user)
    {
        return in_array($user->role, ['manager', 'admin']);
    }
}
