<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organisation;
use App\Auteur;
use App\Publication;

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

    public function publications($year = '0000')
    {
        $publications = [];
        foreach ($this->auteurs as $auteur) {
            $publications[] = $auteur->publications()->where('annee', '>=', $year . '-01-01')->get()->all();
        }

        $return = array();
        array_walk_recursive($publications, function($a) use (&$return) { $return[] = $a; });
        return $return;
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
