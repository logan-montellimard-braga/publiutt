<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return view('search.index');
    }

    public function find(Request $request)
    {
        return view('search.result');
    }
}
