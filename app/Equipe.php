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

    public function linked_equipes()
    {
        $equipes = array();
        $_equipes = array();
        foreach ($this->auteurs as $auteur) {
            foreach ($auteur->publications as $publication) {
                foreach ($publication->auteurs as $p_auteur) {
                    if ($p_auteur->equipe->id != $this->id &&
                        !(in_array($p_auteur->equipe->id, $_equipes))) {
                        $_equipes[] = $p_auteur->equipe->id;
                        $equipes[] = $p_auteur->equipe;
                    }
                }
            }
        }
        return $equipes;
    }
}
