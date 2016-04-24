<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Publication;
use App\Auteur;
use App\Categorie;
use App\Equipe;
use App\Organisation;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return view('search.index', [
            'organisations' => Organisation::all(),
            'equipes' => Equipe::all(),
        ]);
    }

    public function find(Request $request)
    {
        $this->validate($request, [
            'query_v' => 'min:1|required_if:s_type,query,all',
            'equipe' => 'integer|exists:equipes,id|required_if:s_type,func_lab_year',
            'annee' => 'integer|required_if:s_type,func_lab_year|min:1950|max:' . date('Y'),
            'chercheur' => 'integer|exists:auteurs,id|required_if:s_type,func_chercheur_hors_utt',
        ]);

        $publications = array();
        $auteurs = array();
        $categories = Categorie::all();

        switch($request->s_type) {
        case 'query':
            $publications = Publication::where('titre', 'like', '%' . $request->query_v . '%')
                ->orWhere('reference', 'like', '%' . $request->query_v . '%')
                ->orWhere('lieu', 'like', '%' . $request->query_v . '%');
            if (preg_match('/[12]\d{3}/', $request->query_v))
                $publications->orWhere('annee', 'LIKE', $request->query_v . '%');
            $publications = $publications->get();
            break;

        case 'auteur_query':
            $auteurs = Auteur::where('nom', 'like', '%' . $request->query_v . '%')
                ->orWhere('prenom', 'like', '%' . $request->query_v . '%')
                ->get();
            break;

        case 'all':
            $publications = Publication::where('titre', 'like', '%' . $request->query_v . '%')
                ->orWhere('reference', 'like', '%' . $request->query_v . '%')
                ->orWhere('lieu', 'like', '%' . $request->query_v . '%');
            if (preg_match('/[12]\d{3}/', $request->query_v))
                $publications->orWhere('annee', 'LIKE', $request->query_v . '%');
            $publications = $publications->get();
            $auteurs = Auteur::where('nom', 'like', '%' . $request->query_v . '%')
                ->orWhere('prenom', 'like', '%' . $request->query_v . '%')
                ->get();
            break;

        case 'func_all':
            break;

        case 'func_lab_year':
            $_publications = Equipe::find($request->equipe)->publications($request->annee);
            foreach ($_publications as $publication) {
                $publications[] = $publication->id;
            }
            break;

        case 'func_chercheur_hors_utt':
            $_publications = Auteur::find($request->chercheur)->publicationsHorsUTT();
            foreach ($_publications as $publication) {
                $publications[] = $publication->id;
            }

        default:
            break;
        }

        return view('search.result', [
            'type' => $request->s_type,
            'publications' => $publications,
            'auteurs' => $auteurs,
            'categories' => $categories,
            'query_v' => $request->query_v,
        ]);
    }
}
