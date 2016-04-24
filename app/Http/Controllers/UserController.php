<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function switchAdmin(Request $request, User $user)
    {
        if (\Auth::user()->is_admin) {
            if ($user->is_admin) {
                $user->is_admin = 0;
                \Session::flash('flash_message', "L'utilisateur $user->email n'est plus administrateur.");
            }
            else {
                $user->is_admin = 1;
                \Session::flash('flash_message', "L'utilisateur $user->email est maintenant administrateur.");
            }
            $user->save();
        }
        return redirect('/dashboard');
    }

    public function update(Request $request, User $user)
    {
        if (\Auth::user()->id != $user->id) {
            \Session::flash('flash_message_error', "Vous ne pouvez modifier que votre profil.");
            return redirect('/');
        }

        $this->validate($request, [
            'nom' => 'required|alpha|min:2|max:255',
            'prenom' => 'required|alpha|min:2|max:255',
            'equipe' => 'required|integer|exists:equipes,id',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'old_password' => 'required_with:password',
            'password' => 'min:6|confirmed',
        ]);

        if ($request->password) {
            if (\Hash::check($request->old_password, $user->password)) {
                $user->password = \Hash::make($request->password);
            } else {
                return redirect('/profil/edit')->withErrors(['old_password' => "L'ancien mot de passe ne correspond pas."]);
            }
        }
        $user->email = $request->email;
        $user->save();

        $user->auteur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'equipe_id' => $request->equipe,
        ]);

        \Session::flash('flash_message', 'Profil mis à jour avec succès.');
        return redirect('/profil');
    }
}
