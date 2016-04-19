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
        return $this->belongsToMany(Auteur::class);
    }
}
