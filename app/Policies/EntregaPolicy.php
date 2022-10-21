<?php

namespace App\Policies;

use App\Models\Entrega;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntregaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Entrega $entrega)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Entrega $entrega)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Entrega $entrega)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Entrega $entrega)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Entrega $entrega)
    {
        //
    }
}
