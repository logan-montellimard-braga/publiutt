<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Auteur;

class AuteurPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Auteur $auteur)
    {
        return $user->is_admin;
    }

    public function destroy(User $user, Auteur $auteur)
    {
        return $user->is_admin;
    }
}
