@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="col-md-9">
                <a href="{{ url('/publications/new') }}"><i class="fa fa-angle-right"></i>&nbsp;Ajouter une nouvelle publication</a>

                <h2>Publications enregistr&eacute;es</h2>

                <p class="clearfix"></p>

                <ul class="publications">
                  @foreach($publications as $publication)
                    <li>
                      <div class="publication">
                        <h4><a href="{{ url('/publications/show/'.$publication->id) }}">{{ $publication->titre }} ({{ $publication->categorie->initials() }})</a></h4>
                        <h6>{{ $publication->reference }}, <span class="date">{{ date('Y', strtotime($publication->annee)) }}</span></h6>
                        <ul class="authors">
                          @foreach ($publication->auteurs()->withPivot('ordre')->orderBy('ordre')->get() as $auteur)
                            <li><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a></li>
                          @endforeach
                        </ul>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-3">
                <h3>Cat&eacute;gories</h3>
                <ul>
                  @foreach ($categories as $categorie)
                    <li><a href="#">{{ $categorie->nom }}</a></li>
                  @endforeach
                </ul>
                <div class="clearfix"></div>
                <hr class="hidden-xs">
                <h3>&Eacute;quipes UTT-<abbr title="Institut Charles Delaunay">ICD</abbr></h3>
                <ul>
                  @foreach ($organisation->equipes as $equipe)
                    <li><a href="{{ url('/equipes/show/'.$equipe->id) }}">{{ $equipe->nom }}</a></li>
                  @endforeach
                </ul>
              </div>
              </div>
            </div>
          </div>
    </section>
@endsection

@section('title', 'Publications')
