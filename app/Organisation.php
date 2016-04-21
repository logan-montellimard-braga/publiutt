<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Equipe;
use App\Auteur;

class Organisation extends Model
{
    protected $fillable = ['nom', 'etablissement'];

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }

    public function auteurs()
    {
        return $this->hasManyThrough(Auteur::class, Equipe::class);
    }
}
