@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h2>&Eacute;quipes enregistr&eacute;es</h2>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>&Eacute;quipe</th>
                      <th>Description</th>
                      <th>Auteurs</th>
                      @if (Auth::user()->is_admin)
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($organisations as $organisation)
                      <tr class="active">
                        <th colspan="4"><strong>{{ $organisation->nom }} ({{ $organisation->etablissement }})</strong></th>
                      </tr>
                      @foreach ($organisation->equipes as $equipe)
                        <tr>
                          <td>{{ $equipe->nom }}</td>
                          <td>{{ $equipe->description }}</td>
                          <td>{{ count($equipe->auteurs) }}</td>
                          @if (Auth::user()->is_admin)
                          <td class="text-right">
                            <form action="{{ url('equipes/'.$equipe->id) }}" method="POST">
                              {!! csrf_field() !!}
                              {!! method_field('DELETE') !!}

                              <button title="Supprimer" type="submit" class="btn btn-danger btn-xs">
                                <i class="fa fa-btn fa-trash"></i>
                              </button>
                            </form>
                          </td>
                          @endif
                        </tr>
                      @endforeach
                      @if (count($organisation->equipes) === 0)
                        <tr>
                          <td colspan="2">Pas d'&eacute;quipes pour cette organisation</td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row" id="add">
            <div class="col-md-8 col-md-offset-2">
              <h2>Ajouter une &eacute;quipe</h2>
              <form action="{{ url('/equipes') }}" method="POST" role="form">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
                  <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                      <i class="fa fa-fw fa-university"></i>
                    </div>
                    <select class="form-control" name="organisation">
                      <option selected disabled>Organisation de l'&eacute;quipe</option>
                      @foreach ($organisations as $organisation)
                        <option value="{{ $organisation->id }}">{{ $organisation->nom }} ({{ $organisation->etablissement }})</option>
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
                    <input required name="nom" type="text" class="form-control input-lg" value="{{ old('nom') }}" placeholder="Nom de l'&eacute;quipe...">
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
                    <input required name="description" type="text" class="form-control input-lg" value="{{ old('description') }}" placeholder="Description...">
                  </div>
                  @if ($errors->has('description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="form-group text-right">
                  <button type="submit" class="up-small btn btn-lg btn-theme">Ajouter</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </section>
@endsection

@section('title', 'Equipes')
