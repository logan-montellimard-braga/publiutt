@extends('layouts.app')

@section('content')
  @if (Auth::user())
  <div class="modal fade" id="duplicateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Doublon potentiel</h4>
        </div>
        <div class="modal-body">
          <p>
            L'&eacute;quipe `<span id="modal_equipe"></span>` semble d&eacute;j&agrave; exister pour cette organisation.
            <br>
            Êtes-vous s&ucirc;r de vouloir cr&eacute;er cette &eacute;quipe ?
          </p>
        </div>
        <div class="modal-footer">
          <button id="modal_cancel" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
          <button id="modal_ok" type="button" class="btn btn-theme">Envoyer quand m&ecirc;me</button>
        </div>
      </div>
    </div>
  </div>
  @endif

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
                      @if (Auth::user() && Auth::user()->is_admin)
                        <th></th>
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($organisations as $organisation)
                      <tr class="active">
                        <th colspan="4"><a href="{{ url('/organisations/show/'.$organisation->id) }}"><strong>{{ $organisation->nom }} ({{ $organisation->etablissement }})</strong></a></th>
                      </tr>
                      @foreach ($organisation->equipes as $equipe)
                        <tr>
                          <td><a href="{{ url('/equipes/show/'.$equipe->id) }}">{{ $equipe->nom }}</a></td>
                          <td>{{ $equipe->description }}</td>
                          <td>{{ count($equipe->auteurs) }}</td>
                          @if (Auth::user() && Auth::user()->is_admin)
                          <td class="text-right">
                            <a href="{{ url('/equipes/edit/'.$equipe->id) }}" class="btn btn-xs btn-default"><i class="fa fa-cogs"></i></a>
                          </td>
                          <td class="">
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
                          <td colspan="4">Pas d'&eacute;quipes pour cette organisation</td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @if (Auth::user())
          <div class="row" id="add">
            <div class="col-md-8 col-md-offset-2">
              <h2>Ajouter une &eacute;quipe</h2>
              <form action="{{ url('/equipes') }}" method="POST" role="form" class="js-validate manual-validate">
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
        @endif
    </section>

    <script>
    var equipesList = [
        @foreach ($organisations as $organisation)
          @foreach ($organisation->equipes as $equipe)
            { nom: "{!! $equipe->nom !!}", organisation: {!! $equipe->organisation_id !!} },
          @endforeach
        @endforeach
    ];
    var jqReady = function(config) {
        $(document).ready(function() {
            $('#modal_ok').click(function() {
                $('#modal_ok').attr('data-ok', 'true');
                $('#add form').submit();
            });

            var conf = config.validation;
            conf.submitHandler = function(form) {
              if ($('#modal_ok').attr('data-ok') == 'true') form.submit();

              var duplicate = false;

              var newNom = $('input[name="nom"]').val();
              var newOrga = $('select[name="organisation"]').val();

              for (var i = 0, len = equipesList.length; i < len; i++) {
                if (equipesList[i].nom.toLowerCase() === newNom.toLowerCase() &&
                    equipesList[i].organisation == newOrga)
                  duplicate = true;
              }

              if (duplicate) {
                $('#modal_equipe').text(newNom);
                $('#duplicateModal').modal('show');
              } else {
                form.submit();
              }
              return false;
            };

            $('#add form').validate(conf);
        });
    };
    </script>
@endsection

@section('title', 'Equipes')
