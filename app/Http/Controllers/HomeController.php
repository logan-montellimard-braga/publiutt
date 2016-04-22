<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Publication;
use App\Categorie;
use App\Organisation;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $categories = Categorie::all();
        $organisation = Organisation::where('etablissement', 'Université de Technologie de Troyes')->get();
        $publications = Publication::orderBy('created_at', 'desc')->limit(3)->get();
        return view('welcome', [
            'categories' => $categories,
            'organisation' => $organisation[0],
            'publications' => $publications,
        ]);
    }
}
