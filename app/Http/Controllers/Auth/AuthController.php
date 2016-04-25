<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Auteur;
use App\Organisation;
use App\Equipe;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => 'required|alpha|min:2|max:255',
            'prenom' => 'required|alpha|min:2|max:255',
            'equipe' => 'required|integer|exists:equipes,id',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $auteur = Auteur::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'equipe_id' => $data['equipe'],
        ]);

        return $auteur->user()->create([
            'email' => $data['email'],
            'is_admin' => false,
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        $data = array();
        $organisation = Organisation::UTT();
        $equipes = array();
        foreach ($organisation as $org) {
            $equipes = array_merge($equipes, $org->equipes()->get()->all());
        }
        $data['equipes'] = $equipes;
        $data['etablissement'] = $organisation->all()[0]->etablissement;
        return view('auth.register', $data);
    }
}
