<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Equipe;
use App\Auteur;

class Organisation extends Model
{
    protected $fillable = ['nom', 'etablissement'];

    public static function UTT()
    {
        return Organisation::where('etablissement', 'Université de Technologie de Troyes')->get();
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }

    public function auteurs()
    {
        return $this->hasManyThrough(Auteur::class, Equipe::class);
    }

    public function linked_organisations()
    {
        $organisations = array();
        $_organisations = array();
        foreach ($this->auteurs as $auteur) {
            foreach ($auteur->publications as $publication) {
                foreach ($publication->auteurs as $p_auteur) {
                    if ($p_auteur->equipe->organisation->id != $this->id &&
                        !(in_array($p_auteur->equipe->organisation->id, $_organisations))) {
                        $_organisations[] = $p_auteur->equipe->organisation->id;
                        $organisations[] = $p_auteur->equipe->organisation;
                    }
                }
            }
        }
        return $organisations;
    }
}
