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
                <a href="{{ url('/organisations') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux organisations</a>
              @endif
            </div>
            <div class="col-sm-6 text-right">
              @if (Auth::user() && Auth::user()->is_admin)
                <a href="{{ url('/organisations/edit/'.$organisation->id) }}"><i class="fa fa-angle-right"></i>&nbsp;Modifier l'organisation</a>
              @endif
            </div>
          </div>
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

          <br>
          <hr>

          <h2>Auteurs de l'organisation</h2>
          @if (count($auteurs) === 0)
            <p>Il n'y a pas encore d'auteurs enregistr&eacute;s pour cette organisation.</p>
          @else
            <p>{{ $auteurs->total() }} auteurs :
          @endif
          <ul>
            @foreach ($auteurs as $auteur)
              <li>
                <a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a>
                (<a href="{{ url('/equipes/show/'.$auteur->equipe->id) }}"><abbr title="{{ $auteur->equipe->description }}">{{ $auteur->equipe->nom }}</abbr></a>)
                - {{ count($auteur->publications) }} publications
              </li>
            @endforeach
          </ul>
          <div class="text-center">
            {!! $auteurs->links() !!}
          </div>
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
