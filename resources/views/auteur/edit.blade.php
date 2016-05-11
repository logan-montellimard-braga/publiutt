@extends('layouts.app')
@section('title', "Modifier l'auteur")

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <a href="{{ url('/auteurs/show/'.$auteur->id) }}"><i class="fa fa-angle-left"></i>&nbsp;Retour &agrave; l'auteur</a>
        <h2>Modifier l'auteur</h2>
        <form class="js-validate" action="{{ url('/auteurs/edit/'.$auteur->id) }}" method="POST" role="form">
          {!! method_field('PATCH') !!}
          {!! csrf_field() !!}

          <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-tag"></i>
              </div>
              <input required name="nom" type="text" class="form-control input-lg" value="{{ old('nom', $auteur->nom) }}" placeholder="Nom de l'auteur...">
            </div>
            @if ($errors->has('nom'))
            <span class="help-block">
              <strong>{{ $errors->first('nom') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-tags"></i>
              </div>
              <input required name="prenom" type="text" class="form-control input-lg" value="{{ old('prenom', $auteur->prenom) }}" placeholder="Pr&eacute;nom de l'auteur...">
            </div>
            @if ($errors->has('prenom'))
            <span class="help-block">
              <strong>{{ $errors->first('prenom') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('equipe') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-flask"></i>
              </div>
              <select class="form-control" name="equipe">
                <option selected disabled>&Eacute;quipe de l'auteur</option>
                @foreach ($organisations as $organisation)
                <optgroup label="{{ $organisation->nom }} ( {{ $organisation->etablissement }} )">
                  @foreach ($organisation->equipes as $equipe)
                    @if ($equipe->id == $auteur->equipe->id)
                      <option selected value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                    @else
                      <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                    @endif
                  @endforeach
                </optgroup>
                @endforeach
              </select>
            </div>
            <p class="text-right">
              <a href="{{ url('/equipes') }}#add"><i class="fa fa-angle-right"></i>&nbsp;L'&eacute;quipe n'est pas encore enregistr&eacute;e ?</a>
            </p>
            @if ($errors->has('equipe'))
            <span class="help-block">
              <strong>{{ $errors->first('equipe') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
