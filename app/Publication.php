<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['titre', 'reference', 'annee', 'lieu', 'document', 'statut', 'statut_id', 'categorie_id'];
}
