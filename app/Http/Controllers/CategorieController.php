<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Categorie;

class CategorieController extends Controller
{
    public function show(Request $request, Categorie $categorie)
    {
        return view('categorie.show', [
            'categorie' => $categorie,
            'publications' => $categorie->publications()->orderBy('annee', 'desc')->paginate(5),
            'categories' => Categorie::all(),
        ]);
    }
}
