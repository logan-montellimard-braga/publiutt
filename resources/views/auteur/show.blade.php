@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-9">
          @if (Auth::user())
          <div class="row">
            <div class="col-sm-6">
              <a href="{{ url('/auteurs') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux auteurs</a>
            </div>
            <div class="col-sm-6 text-right">
              @if (Auth::user()->auteur->id === $auteur->id)
                <a href="{{ url('/profil/edit') }}"><i class="fa fa-angle-right"></i>&nbsp;Modifier mon profil</a>
              @elseif (Auth::user()->is_admin)
                <a href="{{ url('/auteurs/edit/'.$auteur->id) }}"><i class="fa fa-angle-right"></i>&nbsp;Modifier l'auteur</a>
              @endif
            </div>
          </div>
          @endif
          <h2>D&eacute;tail d'un auteur</h2>

          <p class="clearfix"></p>

          <h4><b>{{ $auteur->prenom }} {{ $auteur->nom }}</b></h4>
          <p>&Eacute;quipe <b><a href="{{ url('/equipes/show/'.$auteur->equipe->id) }}"><abbr title="{{ $auteur->equipe->description }}">{{ $auteur->equipe->nom }}</abbr></a></b>, <b><a href="{{ url('/organisations/show/'.$auteur->equipe->organisation->id) }}">{{ $auteur->equipe->organisation->nom }}</a></b> ({{ $auteur->equipe->organisation->etablissement }}).</p>
          <p>Enregistr&eacute; depuis le {{ date('j/m/Y', strtotime($auteur->created_at)) }}.</p>

          <br>
          <hr>

          <h2>Publications de {{ $auteur->prenom }} {{ $auteur->nom }}</h2>
          @if (count($publications) === 0)
            <p>Cet auteur n'a pas encore post&eacute; de publications.</p>
          @else
            @if ($firstPub === $lastPub)
              <p>{{ $publications->total() }} publications en {{ $firstPub }} (<a href="{{ url('/search/results?s_type=func_chercheur_hors_utt&chercheur='.$auteur->id) }}">{{ count($auteur->publicationsHorsUTT()) }} hors-UTT</a>).</p>
            @else
              <p>{{ $publications->total() }} publications entre {{ $firstPub }} et {{ $lastPub }} (<a href="{{ url('/search/results?s_type=func_chercheur_hors_utt&chercheur='.$auteur->id) }}">{{ count($auteur->publicationsHorsUTT()) }} hors-UTT</a>).</p>
            @endif
            <p>
              <a href="" class="publi-collapse-all"><i class="fa fa-fw fa-minus"></i>&nbsp;Tout minimiser</a>
              <a href="" class="publi-expand-all"><i class="fa fa-fw fa-plus"></i>&nbsp;Tout maximiser</a>
            </p>
          @endif
          <ul class="publications">
            @foreach ($publications as $publication)
              <li class="publication publication-in">
                @include('publication.publication')
              </li>
            @endforeach
          </ul>
          <div class="text-center">
            {!! $publications->links() !!}
          </div>
        </div>
        <div class="col-md-3">
          <h3>Co-auteurs *</h3>
          @if (count($coauteurs) === 0)
            <p>Cet auteur n'a pas publi&eacute; avec d'autres auteurs.</p>
          @endif
          <ul>
            @foreach ($coauteurs as $coauteur)
              <li><span class="badge" title="Nombre de co-publications">{{ $coauteur->nb_publications }}</span> <a title="{{ $coauteur->prenom }} {{ $coauteur->nom }} - {{ $coauteur->equipe->nom }}"href="{{ url('/auteurs/show/'.$coauteur->id) }}">{{ $coauteur->prenom }} {{ $coauteur->nom }}</a></li>
            @endforeach
          </ul>
          <br>
          <p>
            <em>* : Les co-auteurs sont class&eacute;s par ordre d&eacute;croissant du nombre de co-publications avec {{ $auteur->prenom }} {{ $auteur->nom }}.</em>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('title', $auteur->prenom . ' ' . $auteur->nom)
