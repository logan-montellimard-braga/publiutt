<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Publication;

class Statut extends Model
{
    protected $fillable = ['nom'];

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
