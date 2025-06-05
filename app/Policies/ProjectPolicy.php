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
        return in_array($user->role, ['manager', 'admin']);
    }

    public function view(User $user, Project $project)
    {
        return $user->role === 'admin' || $project->users->contains($user);
    }

    public function update(User $user, Project $project)
    {
        return $user->role === 'manager' || $user->id === $project->user_id;
    }

    public function delete(User $user, Project $project)
    {
        return $user->role === 'admin' || $user->id === $project->user_id;
    }

    public function viewAny(User $user)
    {
        return in_array($user->role, ['manager', 'admin']);
    }
}
