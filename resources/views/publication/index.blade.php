@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="col-md-9">
                <h2>Publications enregistr&eacute;es</h2>
              </div>
              <div class="col-md-3">
                <h3>Cat&eacute;gories</h3>
                <ul>
                  @foreach ($categories as $categorie)
                    <li><a href="#">{{ $categorie->nom }}</a></li>
                  @endforeach
                </ul>
                <div class="clearfix"></div>
                <hr class="hidden-xs">
                <h3>&Eacute;quipes UTT-<abbr title="Institut Charles Delaunay">ICD</abbr></h3>
                <ul>
                  @foreach ($organisation->equipes as $equipe)
                    <li><a href="{{ url('/equipes/show/'.$equipe->id) }}">{{ $equipe->nom }}</a></li>
                  @endforeach
                </ul>
              </div>
              </div>
            </div>
          </div>
    </section>
@endsection

@section('title', 'Publications')
