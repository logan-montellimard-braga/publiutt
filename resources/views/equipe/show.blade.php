@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-9">
          <div class="row">
            <div class="col-sm-6">
              @if (Auth::user())
                <a href="{{ url('/equipes') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux &eacute;quipes</a>
              @endif
            </div>
            <div class="col-sm-6 text-right">
              @if (Auth::user() && Auth::user()->is_admin)
              <a href="{{ url('/equipes/edit/'.$equipe->id) }}"><i class="fa fa-angle-right"></i>&nbsp;Modifier l'&eacute;quipe</a>
              @endif
            </div>
          </div>
          <h2>D&eacute;tail d'une &eacute;quipe</h2>

          <p class="clearfix"></p>

          <h4><b>{{ $equipe->nom }}</b></h4>
          <h6><a href="{{ url('/organisations/show/'.$equipe->organisation->id) }}">{{ $equipe->organisation->nom }} ({{ $equipe->organisation->etablissement }})</a></h6>
          <p>{{ $equipe->description }}</p>

          <br>
          <hr>

          <h2>Auteurs de l'&eacute;quipe {{ $equipe->nom }}</h2>
          @if (count($equipe->auteurs) === 0)
            <p>Il n'y a pas encore d'auteurs enregistr&eacute;s pour cette &eacute;quipe.</p>
          @endif
          <ul>
            @foreach ($equipe->auteurs as $auteur)
              <li>
                <a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a>
                - {{ count($auteur->publications) }} publications
              </li>
            @endforeach
          </ul>
        </div>
        <div class="col-md-3">
          <h3>&Eacute;quipes li&eacute;es *</h3>
          @if (count($linked_equipes) === 0)
            <p>Aucune autre &eacute;quipe n'est li&eacute;e &agrave; cette &eacute;quipe.</p>
          @endif
          <ul>
            @foreach ($linked_equipes as $le)
              @if ($le->isEquipeUTT())
                <li><a href="{{ url('/equipes/show/'.$le->id) }}"><abbr title="{{ $le->description }}">{{ $le->nom }}</abbr></a></li>
              @else
                <li><a href="{{ url('/equipes/show/'.$le->id) }}"><i class="fa fa-fw fa-globe"></i>&nbsp;<abbr title="{{ $le->description }}">{{ $le->nom }}</abbr></a></li>
              @endif
            @endforeach
          </ul>
          <br>
          <p><em>* : &Eacute;quipes dont les auteurs ont collabor&eacute; avec des auteurs de l'&eacute;quipe {{ $equipe->nom }}</em></p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('title', $equipe->nom . ' - ' . $equipe->organisation->nom)
