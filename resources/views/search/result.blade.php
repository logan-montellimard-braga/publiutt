@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <a href="{{ url('/search') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour &agrave; la recherche</a>
        <br>
        @if (!($type === 'auteur_query'))
          <h2>Publications</h2>
          <p class="clearfix"></p>
          @if (count($publications) > 1)
            <p>
              {{ count($publications) }} publications trouv&eacute;es.
            </p>
            <p>
              <a href="" class="publi-collapse-all"><i class="fa fa-fw fa-minus"></i>&nbsp;Tout minimiser</a>
              <a href="" class="publi-expand-all"><i class="fa fa-fw fa-plus"></i>&nbsp;Tout maximiser</a>
            </p>
            <br>
          @endif
        @endif

        @if ($type === 'all' || $type === 'query')
          @section('search_query', $query_v)
          @if (count($publications) > 0)
            @foreach ($publications as $publication)
              <div class="row">
                <div class="col-md-8 col-sm-10">
                  @include('publication.publication')
                </div>
              </div>
            @endforeach
          @else
            <p>Pas de publications trouv&eacute;es pour la requ&ecirc;te '{{ $query_v }}'.</p>
          @endif
        @endif

        @if ($type === 'func_lab_year' || $type === 'func_chercheur_hors_utt')
          @if (empty($publications))
            <p>Pas de publications trouv&eacute;es pour cette recherche.</p>
          @else
            @foreach ($categories as $categorie)
              @if (count($categorie->publications) > 0)
                <?php $counter = 0; ?>
                @foreach ($categorie->publications()->orderBy('annee', 'desc')->get() as $publication)
                  @if (in_array($publication->id, $publications))
                    <?php $counter++; ?>
                  @endif
                @endforeach
                @if ($counter > 0)
                  <h3><a href="{{ url('/categories/show/'.$categorie->id) }}">{{ $categorie->nom }}</a></h3>
                  @foreach ($categorie->publications()->orderBy('annee', 'desc')->get() as $publication)
                    @if (in_array($publication->id, $publications))
                      <div class="row">
                        <div class="col-md-8 col-sm-10">
                          @include('publication.publication')
                        </div>
                      </div>
                    @endif
                  @endforeach
                @endif
              @endif
            @endforeach
          @endif
        @endif

        @if ($type === 'func_all')
            @foreach ($categories as $categorie)
              @if (count($categorie->publications) > 0)
                <h3><a href="{{ url('/categories/show/'.$categorie->id) }}">{{ $categorie->nom }}</a></h3>
                @foreach ($categorie->publications()->orderBy('annee', 'desc')->get() as $publication)
                  <div class="row">
                    <div class="col-md-8 col-sm-10">
                      @include('publication.publication')
                    </div>
                  </div>
                @endforeach
                <br>
                <br>
              @endif
            @endforeach
        @endif

        @if ($type === 'all' || $type === 'auteur_query')
          @section('search_query', $query_v)
          @if ($type === 'all')
            <br>
            <hr>
          @endif
          <h2>Auteurs</h2>
          @if (count($auteurs) > 0)
            <p>
              {{ count($auteurs) }} auteurs trouv&eacute;s.
            </p>
            <br>
            <ul>
              @foreach ($auteurs as $auteur)
                <li><a title="{{ $auteur->prenom }} {{ $auteur->nom }} - {{ $auteur->equipe->nom }}"href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a> (<a href="{{ url('/equipes/show/'.$auteur->equipe->id) }}"><abbr title="{{ $auteur->equipe->description }}">{{ $auteur->equipe->nom }}</abbr></a>)</li>
              @endforeach
            </ul>
          @else
            <p>Pas d'auteurs trouv&eacute;s pour la requ&ecirc;te '{{ $query_v }}'.</p>
          @endif
        </div>
      @endif
    </div>
  </div>
</section>
<script>
  var jqReady = function() {
    $('.publi-collapse-all').click();
  };
</script>
@endsection
