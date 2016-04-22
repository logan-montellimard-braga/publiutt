<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Publication;

class PublicationPolicy
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

    public function edit(User $user, Publication $publication)
    {
        return $user->is_admin || $this->isAuteur($user, $publication);
    }

    public function destroy(User $user, Publication $publication)
    {
        return $user->is_admin || $this->isAuteur($user, $publication);
    }

    protected function isAuteur(User $user, Publication $publication)
    {
        foreach ($publication->auteurs as $auteurs) {
            if ($user->auteur_id === $auteur->id) return true;
        }
        return false;
    }
}
