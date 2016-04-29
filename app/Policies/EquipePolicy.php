<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Equipe;

class EquipePolicy
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

    public function edit(User $user, Equipe $equipe)
    {
        return $user->is_admin;
    }

    public function destroy(User $user, Equipe $equipe)
    {
        return $user->is_admin;
    }
}
