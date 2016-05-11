@extends('layouts.app')

@section('title', 'Modifier une équipe')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <a href="{{ url('/equipes/show/'.$equipe->id) }}"><i class="fa fa-angle-left"></i>&nbsp;Retour &agrave; l'&eacute;quipe</a>
        <h2>Modifier l'&eacute;quipe</h2>
        <form class="js-validate" action="{{ url('/equipes/edit/'.$equipe->id) }}" method="POST" role="form">
          {!! method_field('PATCH') !!}
          {!! csrf_field() !!}

          <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-university"></i>
              </div>
              <select class="form-control" name="organisation">
                <option selected disabled>Organisation de l'&eacute;quipe</option>
                @foreach ($organisations as $organisation)
                  @if ($equipe->organisation_id == $organisation->id)
                    <option selected value="{{ $organisation->id }}">{{ $organisation->nom }} ({{ $organisation->etablissement }})</option>
                  @else
                    <option value="{{ $organisation->id }}">{{ $organisation->nom }} ({{ $organisation->etablissement }})</option>
                  @endif
                @endforeach
              </select>
            </div>
            <p class="text-right">
              <a href="{{ url('/organisations') }}#add"><i class="fa fa-angle-right"></i>&nbsp;L'organisation n'est pas encore enregistr&eacute;e ?</a>
            </p>
            @if ($errors->has('organisation'))
            <span class="help-block">
              <strong>{{ $errors->first('organisation') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-tag"></i>
              </div>
              <input required name="nom" type="text" class="form-control input-lg" value="{{ old('nom', $equipe->nom) }}" placeholder="Nom de l'&eacute;quipe...">
            </div>
            @if ($errors->has('nom'))
            <span class="help-block">
              <strong>{{ $errors->first('nom') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-pencil"></i>
              </div>
              <input required name="description" type="text" class="form-control input-lg" value="{{ old('description', $equipe->description) }}" placeholder="Description...">
            </div>
            @if ($errors->has('description'))
            <span class="help-block">
              <strong>{{ $errors->first('description') }}</strong>
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
