<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Equipe;
use App\Organisation;

class EquipeController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    public function index(Request $request)
    {
        $organisations = Organisation::orderBy('nom')->get();
        return view('equipe.index', ['organisations' => $organisations]);
    }

    public function show(Request $request, Equipe $equipe)
    {
        return view('equipe.show', [
            'equipe' => $equipe,
            'linked_equipes' => $equipe->linked_equipes(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|max:255|min:1',
            'description' => 'required',
            'organisation' => 'required|integer|exists:organisations,id',
        ]);

        Equipe::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'organisation_id' => $request->organisation,
        ]);

        \Session::flash('flash_message', "Création de l'équipe `$request->nom` effectuée avec succès.");

        return redirect('/equipes');
    }

    public function destroy(Request $request, Equipe $equipe)
    {
        $this->authorize('destroy', $equipe);

        $equipe->delete();

        \Session::flash('flash_message', "Suppression de l'équipe `$equipe->nom` effectuée avec succès.");

        return redirect('/equipes');
    }
}
