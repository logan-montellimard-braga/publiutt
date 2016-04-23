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

        $result = $matches[0];
        if (count($result) > 2) {
            $result = [$result[0], $result[1]];
        }
        if (count($result) === 1)
            $result[] = substr($this->nom, 1, 1);

        $result = implode('', $result);
        $result = strtoupper($result);

        return $result;
    }

    public static function isInternational(Categorie $categorie)
    {
        $cats = Categorie::where('nom', 'like', '%' . 'international%')
                         ->orWhere('nom', 'like', '%' . 'International%')
                         ->get()
                         ->all();
        return in_array($categorie, $cats);
    }
}
