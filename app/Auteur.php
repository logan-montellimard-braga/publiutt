<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $fillable = ['nom', 'prenom', 'equipe_id'];
}
