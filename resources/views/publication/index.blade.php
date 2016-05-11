@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="col-md-9 col-sm-8">
                @if (Auth::user())
                  <a href="{{ url('/publications/new') }}"><i class="fa fa-angle-right"></i>&nbsp;Ajouter une nouvelle publication</a>
                @endif

                <h2>Publications enregistr&eacute;es</h2>

                <p class="clearfix"></p>

                @if (count($publications) === 0)
                  <p>Il n'y a pas encore de publications.</p>
                @else
                  <p>{{ $publications->total() }} publications.</p>
                  <p>
                    <a href="" class="publi-collapse-all"><i class="fa fa-fw fa-minus"></i>&nbsp;Tout minimiser</a>
                    <a href="" class="publi-expand-all"><i class="fa fa-fw fa-plus"></i>&nbsp;Tout maximiser</a>
                  </p>
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
                @endif

                <hr class="hidden-xs">

                <h3>Rechercher dans la base</h3>

                <p class="clearfix"></p>

                <form class="js-validate" action="{{ url('/search/results') }}" method="GET" role="form">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <div class="input-group input-group-lg">
                      <input required minlength="2" maxlength="255" name="query_v" type="text" class="form-control input-lg" placeholder="Rechercher une publication, un auteur, ...">
                      <input type="hidden" name="s_type" value="all">
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
                @if (count($categories) > 0)
                  <h3>Cat&eacute;gories</h3>
                  <ul>
                    @foreach ($categories as $categorie)
                    <li>
                      <span title="{{ count($categorie->publications) }} publications"class="badge">{{ count($categorie->publications) }}</span>
                      <a title="{{ count($categorie->publications) }} publications dans la catégorie {{ $categorie->nom }}" href="{{ url('/categories/show/'.$categorie->id) }}">{{ $categorie->nom }}</a>
                    </li>
                    @endforeach
                  </ul>
                  <div class="clearfix"></div>
                  <hr class="hidden-xs">
                @endif
                <h3>Statuts</h3>
                <ul>
                  @foreach ($statuts as $statut)
                    <li>
                      <span title="{{ count($statut->publications) }} publications" class="badge">{{ count($statut->publications) }}</span>
                      <a title="{{ count($statut->publications) }} publications avec le statut {{ $statut->nom }}" href="{{ url('/statuts/show/'.$statut->id) }}">{{ $statut->nom }}</a>
                    </li>
                  @endforeach
                </ul>
                @if ($organisation && count($organisation->equipes) > 0)
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
