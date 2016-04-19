<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organisation;
use App\Auteur;

class Equipe extends Model
{
    protected $fillable = ['nom', 'description', 'organisation_id'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function auteurs()
    {
        return $this->hasMany(Auteur::class);
    }
}
