@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-9">
          @if (Auth::user())
            <a href="{{ url('/equipes') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux &eacute;quipes</a>
          @endif
          <h2>D&eacute;tail d'une &eacute;quipe</h2>

          <p class="clearfix"></p>

          <h4><b>{{ $equipe->nom }}</b></h4>
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
              <li><a href="{{ url('/equipes/show/'.$le->id) }}"><abbr title="{{ $le->description }}">{{ $le->nom }}</abbr></a></li>
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
