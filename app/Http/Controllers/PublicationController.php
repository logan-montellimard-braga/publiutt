<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Publication;
use App\Categorie;
use App\Equipe;
use App\Organisation;
use App\Statut;

class PublicationController extends Controller
{

    public function index(Request $request)
    {
        $categories = Categorie::all();
        $organisation = Organisation::where('etablissement', 'Université de Technologie de Troyes')->get();

        return view('publication.index', [
            'categories' => $categories,
            'organisation' => $organisation[0],
        ]);
    }

    public function show(Request $request, Publication $publication)
    {

    }

    public function create(Request $request)
    {
        $categories = Categorie::all();
        $equipes = Equipe::all();
        $statuts = Statut::all();
        return view('publication.new', [
            'categories' => $categories,
            'equipes' => $equipes,
            'statuts' => $statuts,
        ]);
    }

    public function store(Request $request)
    {
    }

    public function edit(Request $request, Publication $publication)
    {
        $this->authorize('edit', $publication);
    }

    public function destroy(Request $request, Publication $publication)
    {
        $this->authorize('destroy', $publication);
    }
}
