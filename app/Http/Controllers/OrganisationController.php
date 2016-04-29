<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Organisation;

class OrganisationController extends Controller
{

    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    public function index(Request $request)
    {
        $organisations = Organisation::orderBy('nom')->get();
        return view('organisation.index', ['organisations' => $organisations]);
    }

    public function show(Request $request, Organisation $organisation)
    {
        return view('organisation.show', [
            'organisation' => $organisation,
            'linked_organisations' => $organisation->linked_organisations(),
            'auteurs' => $organisation->auteurs()->orderBy('equipe_id')->orderBy('nom')->orderBy('prenom')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'institut' => 'required|max:255|min:2',
            'etablissement' => 'required|max:255|min:2',
        ]);

        Organisation::create([
            'nom' => $request->institut,
            'etablissement' => $request->etablissement,
        ]);

        \Session::flash('flash_message', "Création de l'organisation `$request->institut` effectuée avec succès.");

        return redirect('/organisations');
    }

    public function edit(Request $request, Organisation $organisation)
    {
        $this->authorize('edit', $organisation);

        return view('organisation.edit', [
            'organisation' => $organisation,
        ]);
    }

    public function update(Request $request, Organisation $organisation)
    {
        $this->authorize('edit', $organisation);
        $this->validate($request, [
            'institut' => 'required|max:255|min:2',
            'etablissement' => 'required|max:255|min:2',
        ]);

        $organisation->update([
            'nom' => $request->institut,
            'etablissement' => $request->etablissement,
        ]);

        \Session::flash('flash_message', "Modification de l'organisation `$request->institut` effectuée avec succès.");

        return redirect('/organisations/show/' . $organisation->id);
    }

    public function destroy(Request $request, Organisation $organisation)
    {
        $this->authorize('destroy', $organisation);

        $organisation->delete();

        \Session::flash('flash_message', "Suppression de l'organisation `$organisation->nom` effectuée avec succès.");

        return redirect('/organisations');
    }
}
