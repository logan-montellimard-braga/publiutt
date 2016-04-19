<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Publication;

class Categorie extends Model
{
    protected $fillable = ['nom', 'description'];

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
