<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Equipe;

class Organisation extends Model
{
    protected $fillable = ['nom', 'etablissement'];

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
}
