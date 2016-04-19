<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Auteur;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'is_admin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }
}
