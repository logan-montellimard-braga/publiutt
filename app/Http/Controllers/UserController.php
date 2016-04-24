<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function switchAdmin(Request $request, user $user)
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
}
