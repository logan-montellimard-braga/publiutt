@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="col-md-9 col-sm-8">
                <a href="{{ url('/publications/new') }}"><i class="fa fa-angle-right"></i>&nbsp;Ajouter une nouvelle publication</a>

                <h2>Publications enregistr&eacute;es</h2>

                <p class="clearfix"></p>

                <ul class="publications">
                  @foreach($publications as $publication)
                    <li>
                      @include('publication.publication')
                    </li>
                  @endforeach
                </ul>
                <div class="text-center">
                  {!! $publications->links() !!}
                </div>

                <hr class="hidden-xs">

                <h3>Rechercher dans la base</h3>

                <p class="clearfix"></p>

                <form class="" action="{{ url('/search/results') }}" method="GET" role="form">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <div class="input-group input-group-lg">
                      <input required name="query" type="text" class="form-control input-lg" placeholder="Rechercher une publication, un auteur, ...">
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
              <div class="col-md-3 col-sm-4">
                <h3>Cat&eacute;gories</h3>
                <ul>
                  @foreach ($categories as $categorie)
                  <li>
                    <span title="{{ count($categorie->publications) }} publications"class="badge">{{ count($categorie->publications) }}</span>
                    <a title="{{ count($categorie->publications) }} publications dans la catégorie {{ $categorie->nom }}" href="{{ url('/search/results/?categorie='.$categorie->id) }}">{{ $categorie->nom }}</a>
                  </li>
                  @endforeach
                </ul>
                <div class="clearfix"></div>
                <hr class="hidden-xs">
                <h3>Statuts</h3>
                <ul>
                  @foreach ($statuts as $statut)
                    <li>
                      <span title="{{ count($statut->publications) }} publications" class="badge">{{ count($statut->publications) }}</span>
                      <a title="{{ count($statut->publications) }} publications avec le statut {{ $statut->nom }}" href="{{ url('/search/results/?statut='.$statut->id) }}">{{ $statut->nom }}</a>
                    </li>
                  @endforeach
                </ul>
                @if ($organisation)
                  <div class="clearfix"></div>
                  <hr class="hidden-xs">
                  <h3>&Eacute;quipes UTT-<abbr title="Institut Charles Delaunay">ICD</abbr></h3>
                  <ul>
                    @foreach ($organisation->equipes as $equipe)
                      <li><a href="{{ url('/equipes/show/'.$equipe->id) }}"><abbr title="{{ $equipe->description }}">{{ $equipe->nom }}</abbr></a></li>
                    @endforeach
                  </ul>
                @endif
              </div>
              </div>
            </div>
          </div>
    </section>
@endsection

@section('title', 'Publications')
