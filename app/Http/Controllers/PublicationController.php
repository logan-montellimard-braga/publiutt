<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Auteur;
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
        $publications = Publication::orderBy('created_at', 'desc')->get();

        return view('publication.index', [
            'categories' => $categories,
            'organisation' => $organisation[0],
            'publications' => $publications,
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
        $organisations = Organisation::all();
        return view('publication.new', [
            'categories' => $categories,
            'equipes' => $equipes,
            'statuts' => $statuts,
            'organisations' => $organisations,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titre' => 'required|max:255|min:2',
            'reference' => 'required|max:255|min:1',
            'annee' => 'required|max:' . date('Y') . '|min:1950|integer',
            'statut' => 'required|exists:statuts,id',
            'categorie' => 'required|exists:categories,id',
            'document' => 'required',
            'lieu' => 'required_if:is_conference,true|min:2|max:255',
            'auteurs' => 'required',
        ]);

        $filename = time() . rand(11111, 99999) . '.' . $request->file('document')->getClientOriginalExtension();
        $uploads = base_path() . '/public/upload/';
        $request->file('document')->move($uploads, $filename);

        $pub = Publication::create([
            'titre' => $request->titre,
            'reference' => $request->reference,
            'annee' => $request->annee . '-01-01',
            'statut_id' => $request->statut,
            'categorie_id' => $request->categorie,
            'document' => $filename,
            'lieu' => $request->lieu,
        ]);

        $auteurs = explode(',', $request->auteurs);
        foreach ($auteurs as $n => $auteur_id) {
            $auteur = Auteur::find($auteur_id);
            $auteur->publications()->attach($pub->id, ['ordre' => $n]);
        }

        \Session::flash('flash_message', "Création de la publication `$request->titre` effectuée avec succès.");

        return redirect('/publications');
    }

    public function edit(Request $request, Publication $publication)
    {
        $this->authorize('edit', $publication);

        $categories = Categorie::all();
        $equipes = Equipe::all();
        $statuts = Statut::all();
        $organisations = Organisation::all();

        return view('publication.edit', [
            'pub' => $publication,
            'categories' => $categories,
            'equipes' => $equipes,
            'statuts' => $statuts,
            'organisations' => $organisations,
        ]);
    }

    public function update(Request $request, Publication $publication)
    {
        $this->validate($request, [
            'titre' => 'required|max:255|min:2',
            'reference' => 'required|max:255|min:1',
            'annee' => 'required|max:' . date('Y') . '|min:1950|integer',
            'statut' => 'required|exists:statuts,id',
            'categorie' => 'required|exists:categories,id',
            'document' => 'required',
            'lieu' => 'required_if:is_conference,true|min:2|max:255',
        ]);

        $filename = time() . rand(11111, 99999) . '.' . $request->file('document')->getClientOriginalExtension();
        $uploads = base_path() . '/public/upload/';
        $request->file('document')->move($uploads, $filename);

        $ups = array(
            'titre' => $request->titre,
            'reference' => $request->reference,
            'annee' => $request->annee . '-01-01',
            'statut_id' => $request->statut,
            'categorie_id' => $request->categorie,
            'document' => $filename,
            'lieu' => $request->lieu,
        );
        $publication->update($ups);

        $auteurs = explode(',', $request->auteurs);
        $arr = array();
        foreach ($auteurs as $n => $auteur_id) {
            $arr[intval($auteur_id)] = array('ordre' => $n);
        }
        $publication->auteurs()->sync($arr);

        \Session::flash('flash_message', "Modification de la publication `$request->titre` effectuée avec succès.");

        return redirect('/publications/show/' . $publication->id);
    }

    public function destroy(Request $request, Publication $publication)
    {
        $this->authorize('destroy', $publication);
    }
}
