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
        $this->validate($request, [
            'per_page' => 'integer|min:1|max:100',
        ]);

        $per_page = $request->per_page ? $request->per_page : 5;

        $publications = Publication::orderBy('annee', 'desc')->orderBy('created_at', 'desc')->paginate($per_page);

        return view('publication.index', [
            'categories' => Categorie::all(),
            'organisation' => Organisation::UTT()[0],
            'publications' => $publications,
            'statuts' => Statut::all(),
        ]);
    }

    public function show(Request $request, Publication $publication)
    {
        return view('publication.show', [
            'publication' => $publication,
            'equipes' => $publication->equipes(),
            'organisations' => $publication->organisations(),
        ]);
    }

    public function create(Request $request)
    {
        return view('publication.new', [
            'categories' => Categorie::all(),
            'equipes' => Equipe::all(),
            'statuts' => Statut::all(),
            'organisations' => Organisation::all(),
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

        $auteurs_id = array();
        foreach ($publication->auteurs as $auteur) {
            $auteurs_id[] = $auteur->id;
        }

        return view('publication.edit', [
            'pub' => $publication,
            'categories' => $categories,
            'equipes' => $equipes,
            'statuts' => $statuts,
            'organisations' => $organisations,
            'auteurs' => $auteurs_id,
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
            'lieu' => 'required_if:is_conference,true|min:2|max:255',
            'auteurs' => 'required',
        ]);

        $ups = array(
            'titre' => $request->titre,
            'reference' => $request->reference,
            'annee' => $request->annee . '-01-01',
            'statut_id' => $request->statut,
            'categorie_id' => $request->categorie,
            'lieu' => $request->lieu,
        );
        if ($request->hasFile('document')) {
            $filename = time() . rand(11111, 99999) . '.' . $request->file('document')->getClientOriginalExtension();
            $uploads = base_path() . '/public/upload/';
            $request->file('document')->move($uploads, $filename);
            $ups['document'] = $filename;
        }

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

        $publication->auteurs()->sync([]);
        $publication->delete();

        \Session::flash('flash_message', "Suppression de la publication effectuée avec succès.");

        return redirect('/publications');
    }
}
