@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2>Bienvenue, <b>{{ Auth::user()->auteur->prenom }} {{ Auth::user()->auteur->nom }}</b> !</h2>
          </div>
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
