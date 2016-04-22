@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
  <header class="main">
    <div class="container">
      <div class="wrapper"></div>
      <div class="dark"></div>
      <div class="content">
        <div class="row">
          <div class="col-sm-12">
            <h1>Publi<b>UTT</b></h1>
            <span>La biblioth&egrave;que des publications scientifiques</span>
            <div class="clearfix"></div>
            <span>par les chercheurs de l'UTT</span>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 action">
            @if (Auth::guest())
              <a href="{{ url('/login') }}"><i class="fa fa-angle-right"></i>&nbsp;Je suis chercheur &agrave; l'UTT</a>
            @else
            <a href="{{ url('/publications/new') }}"><i class="fa fa-angle-right"></i>&nbsp;J'ajoute une publication</a>
            @endif
          </div>
        </div>
      </div>
      <div class="bottom-content to-content">
        <div class="row">
          <div class="col-sm-12">
            <i class="fa fa-angle-double-down"></i>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 col-md-offset-1">
          <h2>Derni&egrave;res publications</h2>

          <p class="clearfix"></p>

          <ul class="publications">
            @foreach($publications as $publication)
              <li>
                <div class="publication">
                  <h4><a href="{{ url('/publications/show/'.$publication->id) }}">{{ $publication->titre }} ({{ $publication->categorie->initials() }})</a></h4>
                  <h6>{{ $publication->reference }}, <span class="date">{{ date('Y', strtotime($publication->annee)) }}</span></h6>
                  <ul class="authors">
                    @foreach ($publication->auteurs()->withPivot('ordre')->orderBy('ordre')->get() as $auteur)
                      <li><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </li>
            @endforeach
          </ul>

          <p class="text-right">
            <a href="{{ url('/publications') }}"><i class="fa fa-plus"></i>&nbsp;Voir toutes les publications</a>
          </p>

          <hr class="hidden-xs">

          <h3>Rechercher dans la base</h3>

          <p class="clearfix"></p>

          <form class="" action="{{ url('/search/results') }}" method="GET" role="form">
            {!! csrf_field() !!}
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control input-lg" placeholder="Rechercher une publication, un auteur, ...">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-lg btn-theme"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
          </form>

          <p class="text-right">
            <a href="{{ url('/search') }}"><i class="fa fa-search-plus"></i>&nbsp;Effectuer une recherche avanc&eacute;e</a>
          </p>

        </div>


        <div class="col-sm-4 col-md-3">
          <hr class="visible-xs">
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
  </section>

@endsection
