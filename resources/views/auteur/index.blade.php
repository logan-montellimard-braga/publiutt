@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h2>Auteurs enregistr&eacute;es</h2>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Pr&eacute;nom</th>
                      <th>&Eacute;quipe</th>
                      <th>Publications</th>
                      @if (Auth::user()->is_admin)
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($organisations as $organisation)
                      <tr class="active">
                        <th colspan="5"><strong>{{ $organisation->nom }} ({{ $organisation->etablissement }})</strong></th>
                      </tr>
                      @foreach ($organisation->equipes as $equipe)
                        @foreach ($equipe->auteurs as $auteur)
                          <tr>
                            <td>{{ strtoupper($auteur->nom) }}</td>
                            <td>{{ $auteur->prenom }}</td>
                            <td>{{ $equipe->nom }}</td>
                            <td>{{ count($auteur->publications) }}</td>
                            @if (Auth::user()->is_admin)
                            <td class="text-right">
                              <form action="{{ url('auteurs/'.$auteur->id) }}" method="POST">
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
                      @endforeach
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row" id="add">
            <div class="col-md-8 col-md-offset-2">
              <h2>Ajouter un auteur</h2>
              <form action="{{ url('/auteurs') }}" method="POST" role="form">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                  <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                      <i class="fa fa-fw fa-tag"></i>
                    </div>
                    <input required name="nom" type="text" class="form-control input-lg" value="{{ old('nom') }}" placeholder="Nom de l'auteur...">
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
                      <i class="fa fa-fw fa-tag"></i>
                    </div>
                    <input required name="prenom" type="text" class="form-control input-lg" value="{{ old('prenom') }}" placeholder="Pr&eacute;nom de l'auteur...">
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
                            <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
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
                  <button type="submit" class="up-small btn btn-lg btn-theme">Ajouter</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </section>
@endsection

@section('title', 'Auteurs')
