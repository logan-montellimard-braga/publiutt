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
            L'organisation `<span id="modal_organisation"></span>` semble d&eacute;j&agrave; exister.
            <br>
            Êtes-vous s&ucirc;r de vouloir cr&eacute;er cette organisation ?
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

                              <a href="{{ url('/organisations/edit/'.$organisation->id) }}" class="btn btn-xs btn-default"><i class="fa fa-cogs"></i></a>
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
              <form class="js-validate manual-validate" action="{{ url('/organisations') }}" method="POST" role="form">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('institut') ? ' has-error' : '' }}">
                  <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                      <i class="fa fa-fw fa-flask"></i>
                    </div>
                    <input minlength="2" maxlength="255" required name="institut" type="text" class="form-control input-lg" value="{{ old('institut') }}" placeholder="Institut de recherche...">
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
                    <input minlength="2" maxlength="255" required name="etablissement" type="text" class="form-control input-lg" value="{{ old('etablissement') }}" placeholder="&Eacute;tablissement...">
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

    <script>
      var orgaList = [
      @foreach ($organisations as $organisation)
        { nom: "{!! $organisation->nom !!}", etablissement: "{!! $organisation->etablissement !!}" },
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

          var newNom = $('input[name="institut"]').val();
          var newEtab = $('input[name="etablissement"]').val();

          for (var i = 0, len = orgaList.length; i < len; i++) {
            if (orgaList[i].nom.toLowerCase() === newNom.toLowerCase() &&
                orgaList[i].etablissement.toLowerCase() === newEtab.toLowerCase())
              duplicate = true;
          }

          if (duplicate) {
            $('#modal_organisation').text(newNom + ' (' + newEtab + ')');
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

@section('title', 'Organisations')
