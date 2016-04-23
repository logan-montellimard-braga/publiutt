<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Equipe;
use App\User;
use App\Publication;
use App\Statut;
use App\Categorie;
use App\Organisation;

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

    public function coauteurs()
    {
        $coauteurs = array();
        $_coauteurs = array();
        foreach ($this->publications as $publications) {
            foreach ($publications->auteurs as $coauteur) {
                if ($coauteur->id != $this->id && !(in_array($coauteur->id, $_coauteurs))) {
                    $_coauteurs[] = $coauteur->id;
                    $coauteurs[] = $coauteur;
                }
            }
        }
        return $coauteurs;
    }

    public function isChercheurUTT()
    {
        return in_array($this->organisation, Organisation::UTT()->all());
    }

    protected function XPublicationYear($sort)
    {
        $pub = $this->publications()->orderBy('annee', $sort)->limit(1)->get();
        if (count($pub) > 0) {
            $pub = $pub[0];
            $pub = date('Y', strtotime($pub->annee));
        } else $pub = 0;

        return intval($pub);
    }

    public function firstPublicationYear()
    {
        return $this->XPublicationYear('asc');
    }

    public function lastPublicationYear()
    {
        return $this->XPublicationYear('desc');
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class)->withPivot('ordre');
    }

    public static function doublons()
    {
        $_doublons = \DB::Table('auteurs')
            ->select(\DB::raw('*, COUNT(*)'))
            ->groupBy('nom', 'prenom')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $doublons = array();
        foreach ($_doublons as $_doublon)
            $doublons[] = Auteur::find($_doublon->id);

        return $doublons;
    }

    public function getPerformanceScore()
    {
        $score = 0;

        foreach ($this->publications as $publication) {
            $score += 100;

            if (date('Y', strtotime($publication->annee)) === '1994')
                $score += 25;

            if ($publication->statut->id == Statut::publie()->id)
                $score += 15;

            if (Categorie::isInternational($publication->categorie))
                $score += 15;

            $ordre = $publication->pivot->ordre + 1;
            $score += 100 / $ordre;
        }
        foreach ($this->coauteurs() as $collaborateur) {
            $score += 20;

            if ($collaborateur->equipe->id != $this->equipe->id &&
                $collaborateur->organisation->id != $this->organisation->id)
                $score += 10;

            if ($collaborateur->organisation->id != $this->organisation->id)
                $score += 20;

            if (count($collaborateur->coauteurs()) > 20)
                $score -= 150;
        }

        return floor($score);
    }

    public static function byPerformance()
    {
        $auteurs = Auteur::all()->all();
        usort($auteurs, function(Auteur $a, Auteur $b) {
            $a_perf = $a->getPerformanceScore();
            $b_perf = $b->getPerformanceScore();

            if ($a_perf === $b_perf) return 0;
            if ($a_perf > $b_perf) return -1;
            return 1;
        });
        return $auteurs;
    }
}
