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

    public static function publie()
    {
        return Statut::where('nom', 'Publié')->get()[0];
    }

    public static function revision()
    {
        return Statut::where('nom', 'En révision')->get()[0];
    }

    public static function soumis()
    {
        return Statut::where('nom', 'Soumis')->get()[0];
    }
}
