@extends('layouts.app')

@section('title', 'Recherche')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <h2>Trouver des publications</h2>

        <h5><a data-toggle="collapse" aria-expanded="true" aria-controls="pub_recherche_directe" href="#pub_recherche_directe">Recherche directe</a></h5>
        <form data-group="publi" id="pub_recherche_directe" class="collapse in" action="{{ url('/search/results') }}" method="GET" role="form">
          {!! csrf_field() !!}
          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <input required name="query_v" type="text" class="form-control input-lg" placeholder="Titre, référence, lieu, ann&eacute;e...">
            </div>
          </div>

          <input name="s_type" type="hidden" value="query">

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Rechercher</button>
          </div>

          <br>
        </form>

        <h5><a href="#pub_func_all" aria-expanded="false" aria-controls="pub_func_all" data-toggle="collapse">Liste des publications tri&eacute;es par cat&eacute;gorie et par ann&eacute;e</a></h5>
        <form id="pub_func_all" data-group="publi" class="collapse" action="{{ url('/search/results') }}" method="GET" role="form">
          {!! csrf_field() !!}
          <input name="s_type" type="hidden" value="func_all">

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Rechercher</button>
          </div>
          <br>
        </form>

        <h5><a href="#pub_func_lab_year" data-toggle="collapse" aria-expanded="false" aria-controls="pub_func_all">Recherche par laboratoire &agrave; partir d'une ann&eacute;e</a></h5>
        <form id="pub_func_lab_year" data-group="publi" class="collapse" action="{{ url('/search/results') }}" method="GET" role="form">
          {!! csrf_field() !!}
          <div class="form-group{{ $errors->has('equipe') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-flask"></i>
              </div>
              <select required class="form-control" name="equipe">
                <option selected disabled>Laboratoire</option>
                @foreach ($organisations as $organisation)
                  <optgroup label="{{ $organisation->nom }} ({{ $organisation->etablissement }})">
                    @foreach ($organisation->equipes as $equipe)
                      <option value="{{ $equipe->id }}">{{ $equipe->nom }} ({{ count($equipe->publications()) }} publications)</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
            @if ($errors->has('equipe'))
            <span class="help-block">
              <strong>{{ $errors->first('equipe') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('annee') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-calendar-o"></i>
              </div>
              <input required name="annee" type="number" class="form-control input-lg" value="{{ old('annee') }}" placeholder="Ann&eacute;e...">
            </div>
            @if ($errors->has('annee'))
            <span class="help-block">
              <strong>{{ $errors->first('annee') }}</strong>
            </span>
            @endif
          </div>

          <input name="s_type" type="hidden" value="func_lab_year">

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Rechercher</button>
          </div>

          <br>
        </form>

        <h5><a href="#pub_func_chercheur_hors_utt" data-toggle="collapse" aria-expanded="false" aria-controls="pub_func_chercheur_hors_utt">Collaborations hors-UTT d'un chercheur</a></h5>
        <form id="pub_func_chercheur_hors_utt" data-group="publi" class="collapse" action="{{ url('/search/results') }}" method="GET" role="form">
          {!! csrf_field() !!}
          <div class="form-group{{ $errors->has('chercheur') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-user"></i>
              </div>
              <select required class="form-control" name="chercheur">
                <option selected disabled>Chercheur</option>
                @foreach ($organisations as $organisation)
                <optgroup label="{{ $organisation->nom }} ({{ $organisation->etablissement }})">
                  @foreach ($organisation->equipes as $equipe)
                  <optgroup label="{{ $equipe->nom }}">
                    @foreach ($equipe->auteurs as $auteur)
                    <option value="{{ $auteur->id }}">{{ $auteur->prenom }} {{ $auteur->nom }} ({{ count($auteur->publicationsHorsUTT()) }} p. hors-UTT)</option>
                    @endforeach
                  </optgroup>
                  @endforeach
                </optgroup>
                @endforeach
              </select>
            </div>
            @if ($errors->has('chercheur'))
            <span class="help-block">
              <strong>{{ $errors->first('chercheur') }}</strong>
            </span>
            @endif
          </div>

          <input name="s_type" type="hidden" value="func_chercheur_hors_utt">

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Rechercher</button>
          </div>
        </form>

        <br>
        <hr>
        <br>

        <h2>Trouver des auteurs</h2>
        <h5><a data-toggle="collapse" aria-expanded="true" aria-controls="auteur_recherche_directe" href="#auteur_recherche_directe">Recherche directe</a></h5>
        <form id="auteur_recherche_directe" class="collapse in" action="{{ url('/search/results') }}" method="GET" role="form">
          {!! csrf_field() !!}
          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <input required name="query_v" type="text" class="form-control input-lg" placeholder="Nom, prénom, ...">
            </div>
          </div>

          <input name="s_type" type="hidden" value="auteur_query">

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Rechercher</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</section>
@endsection
