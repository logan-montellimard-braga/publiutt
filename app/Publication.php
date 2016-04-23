<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Statut;
use App\Categorie;
use App\Auteur;

class Publication extends Model
{
    protected $fillable = ['titre', 'reference', 'annee', 'lieu', 'document', 'statut', 'statut_id', 'categorie_id'];

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function auteurs()
    {
        return $this->belongsToMany(Auteur::class)->withPivot('ordre');
    }

    public static function doublons()
    {
        $_doublons = \DB::Table('publications')
            ->select(\DB::raw('*, COUNT(*)'))
            ->groupBy('titre', 'annee')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $doublons = array();
        foreach ($_doublons as $_doublon)
            $doublons[] = Publication::find($_doublon->id);

        return $doublons;
    }

    public static function doublons_auteurs()
    {
        return [];
    }

    public static function noAuteurUTT()
    {
        $_publications = Publication::all();
        $publications = array();
        foreach ($_publications as $_pub)
            if (!$_pub->hasAuteurUTT()) $publications[] = $_pub;
        return $publications;
    }

    protected function hasAuteurUTT()
    {
        foreach ($this->auteurs as $auteur)
            if ($auteur->isChercheurUTT()) return true;
        return false;
    }

    public function equipes()
    {
        $equipes = array();
        foreach ($this->auteurs as $auteur) {
            if (!in_array($auteur->equipe, $equipes))
                $equipes[] = $auteur->equipe;
        }
        return $equipes;
    }

    public function organisations()
    {
        $organisations = array();
        foreach ($this->auteurs as $auteur) {
            if (!in_array($auteur->equipe->organisation, $organisations))
                $organisations[] = $auteur->equipe->organisation;
        }
        return $organisations;
    }
}
