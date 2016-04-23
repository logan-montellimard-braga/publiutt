@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h2>Organisations enregistr&eacute;es</h2>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Institut de recherche</th>
                      <th>&Eacute;tablissement</th>
                      <th>&Eacute;quipes</th>
                      <th>Auteurs</th>
                      @if (Auth::user() && Auth::user()->is_admin)
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($organisations as $organisation)
                      <tr>
                        <td><a href="{{ url('/organisations/show/'.$organisation->id) }}">{{ $organisation->nom }}</a></td>
                        <td><a href="{{ url('/organisations/show/'.$organisation->id) }}">{{ $organisation->etablissement }}</a></td>
                        <td>{{ count($organisation->equipes) }}</td>
                        <td>{{ count($organisation->auteurs) }}</td>
                        @if (Auth::user() && Auth::user()->is_admin)
                          <td class="text-right">
                            <form action="{{ url('organisations/'.$organisation->id) }}" method="POST">
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
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @if (Auth::user())
          <div class="row" id="add">
            <div class="col-md-8 col-md-offset-2">
              <h2>Ajouter une organisation</h2>
              <form action="{{ url('/organisations') }}" method="POST" role="form">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('institut') ? ' has-error' : '' }}">
                  <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                      <i class="fa fa-fw fa-flask"></i>
                    </div>
                    <input required name="institut" type="text" class="form-control input-lg" value="{{ old('institut') }}" placeholder="Institut de recherche...">
                  </div>
                  @if ($errors->has('institut'))
                  <span class="help-block">
                    <strong>{{ $errors->first('institut') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="form-group{{ $errors->has('etablissement') ? ' has-error' : '' }}">
                  <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                      <i class="fa fa-fw fa-university"></i>
                    </div>
                    <input required name="etablissement" type="text" class="form-control input-lg" value="{{ old('etablissement') }}" placeholder="&Eacute;tablissement...">
                  </div>
                  @if ($errors->has('etablissement'))
                  <span class="help-block">
                    <strong>{{ $errors->first('etablissement') }}</strong>
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
        @endif
    </section>
@endsection

@section('title', 'Organisations')
