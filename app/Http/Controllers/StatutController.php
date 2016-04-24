<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Statut;

class StatutController extends Controller
{
    public function show(Request $request, Statut $statut)
    {
        return view('statut.show', [
            'statut' => $statut,
            'statuts' => Statut::all(),
            'publications' => $statut->publications()->orderBy('annee', 'desc')->paginate(5),
        ]);
    }
}
