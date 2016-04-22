@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <p class="text-right">
          @if (Auth::user()->is_admin)
            <em>Connect&eacute; en tant qu'administrateur</em>
          @endif
        </p>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2>
              Bonjour, <b>{{ Auth::user()->auteur->prenom }} {{ Auth::user()->auteur->nom }}</b>
            </h2>
          </div>
          <div class="panel-body">
            <p>
              Vous recherchez avec l'&eacute;quipe <b>{{ Auth::user()->auteur->equipe->nom }}</b> de l'organisation <b>{{ Auth::user()->auteur->organisation->nom }}</b> ({{ Auth::user()->auteur->organisation->etablissement }})</p>
            </p>
            @if (count(Auth::user()->auteur->publications) === 0)
              <p>Vous n'avez pas encore post&eacute; de publication.
                <br>
                <a href="{{ url('/publications/new') }}"><i class="fa fa-angle-right"></i>&nbsp;J'ajoute une nouvelle publication</a>
              </p>
            @else
              <p>Vous &ecirc;tes (co-)auteur de <b>{{ count(Auth::user()->auteur->publications) }}</b> publications.</p>
            @endif
            <p class="text-center">
              <a class="btn btn-theme" href="{{ url('/auteurs/show/'.Auth::user()->auteur->id) }}">Consulter mon profil</a>
            </p>
          </div>
          <hr>
          <div class="panel-body">
            <div class="text-center">
              <div class="col-sm-3">
                <a class="dash-icon" href="{{ url('/publications') }}"><i class="fa fa-3x fa-pencil fa-fw"></i><br>Publications</a>
              </div>
              <div class="col-sm-3">
                <a class="dash-icon" href="{{ url('/organisations') }}"><i class="fa fa-3x fa-university fa-fw"></i><br>Organisations</a>
              </div>
              <div class="col-sm-3">
                <a class="dash-icon" href="{{ url('/equipes') }}"><i class="fa fa-3x fa-flask fa-fw"></i><br>&Eacute;quipes</a>
              </div>
              <div class="col-sm-3">
                <a class="dash-icon" href="{{ url('/auteurs') }}"><i class="fa fa-3x fa-users fa-fw"></i><br>Auteurs</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
