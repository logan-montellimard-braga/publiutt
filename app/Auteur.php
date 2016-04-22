<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Equipe;
use App\User;
use App\Publication;

class Auteur extends Model
{
    protected $fillable = ['nom', 'prenom', 'equipe_id'];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function organisation()
    {
        return $this->equipe->organisation();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class)->withPivot('ordre');
    }
}
