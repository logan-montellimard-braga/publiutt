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

    public function initials()
    {
        $str = $this->nom;
        $expr = '/(?<=\s|^)[a-z]/i';
        preg_match_all($expr, $str, $matches);
        $result = implode('', $matches[0]);
        $result = strtoupper($result);

        return $result;
    }
}
