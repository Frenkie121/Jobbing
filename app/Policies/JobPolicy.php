<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // public function viewAny()
    // {
    //     // return true;
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role_id === 2 
                        ? Response::allow()
                        : Response::deny('You don\'t have the right role to perform this action.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Job $job)
    {
        return $user->userable_id === $job->customer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Job $job)
    {
        return $user->userable_id === $job->customer_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Job $job)
    {
        //
    }
}
