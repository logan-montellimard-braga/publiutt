@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-9">
          @if (Auth::user())
            <a href="{{ url('/organisations') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux organisations</a>
          @endif
          <h2>D&eacute;tail d'une organisation</h2>

          <p class="clearfix"></p>

          <h4><b>{{ $organisation->nom }}</b></h4>
          <p>{{ $organisation->etablissement }}</p>

          <br>
          <hr>

          <h2>&Eacute;quipes de l'organisation {{ $organisation->nom }}</h2>
          @if (count($organisation->equipes) === 0)
            <p>Il n'y a pas encore d'&eacute;quipe enregistr&eacute;e pour cette organisation.</p>
          @endif
          <ul>
            @foreach ($organisation->equipes as $equipe)
              <li>
                <a href="{{ url('/equipes/show/'.$equipe->id) }}"><abbr title="{{ $equipe->description }}">{{ $equipe->nom }}</abbr></a>
                - {{ count($equipe->auteurs) }} auteurs
              </li>
            @endforeach
          </ul>
        </div>
        <div class="col-md-3">
          <h3>Organisations li&eacute;es *</h3>
          @if (count($linked_organisations) === 0)
            <p>Aucune autre organisation n'est li&eacute;e &agrave; cette organisation.</p>
          @endif
          <ul>
            @foreach ($linked_organisations as $lo)
              <li><a href="{{ url('/organisations/show/'.$lo->id) }}">{{ $lo->nom }} ({{ $lo->etablissement }})</a></li>
            @endforeach
          </ul>
          <br>
          <p><em>* : Organisations dont les auteurs ont collabor&eacute; avec des auteurs de l'organisation {{ $organisation->nom }}</em></p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('title', $organisation->nom)