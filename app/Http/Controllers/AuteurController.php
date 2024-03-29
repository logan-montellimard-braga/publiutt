<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Auteur;
use App\Organisation;

class AuteurController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    public function index(Request $request)
    {
        $organisations = Organisation::orderBy('nom')->get();
        return view('auteur.index', ['organisations' => $organisations]);
    }

    public function show(Request $request, Auteur $auteur)
    {
        if (\Auth::user() && $auteur->id === \Auth::user()->auteur->id)
            return redirect('/profil');

        return view('auteur.show', [
            'publications' => $auteur->publications()->orderBy('categorie_id')->orderBy('annee', 'desc')->orderBy('created_at', 'desc')->paginate(3),
            'coauteurs' => $auteur->coauteurs(),
            'auteur' => $auteur,
            'firstPub' => $auteur->firstPublicationYear(),
            'lastPub' => $auteur->lastPublicationYear(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|max:255|min:2',
            'prenom' => 'required|max:255|min:2',
            'equipe' => 'required|integer|exists:equipes,id',
        ]);

        Auteur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'equipe_id' => $request->equipe,
        ]);

        \Session::flash('flash_message', "Création de l'auteur `$request->prenom $request->nom` effectuée avec succès.");

        return redirect('/auteurs');
    }

    public function edit(Request $request, Auteur $auteur)
    {
        $this->authorize('edit', $auteur);

        return view('auteur.edit', [
            'auteur' => $auteur,
            'organisations' => Organisation::orderBy('nom')->get(),
        ]);
    }

    public function update(Request $request, Auteur $auteur)
    {
        $this->authorize('edit', $auteur);
        $this->validate($request, [
            'nom' => 'required|max:255|min:2',
            'prenom' => 'required|max:255|min:2',
            'equipe' => 'required|integer|exists:equipes,id',
        ]);

        $auteur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'equipe_id' => $request->equipe,
        ]);

        \Session::flash('flash_message', "Modification de l'auteur `$request->prenom $request->nom` effectuée avec succès.");

        return redirect('/auteurs/show/' . $auteur->id);
    }

    public function destroy(Request $request, Auteur $auteur)
    {
        $this->authorize('destroy', $auteur);

        if ($auteur->user != null)
            $auteur->user->delete();
        $auteur->delete();

        \Session::flash('flash_message', "Suppression de l'auteur `$auteur->prenom $auteur->nom` effectuée avec succès.");

        return redirect('/auteurs');
    }
}
