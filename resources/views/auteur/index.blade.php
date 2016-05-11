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
          <p class="duplicate">
            L'auteur `<span class="modal_auteur"></span>` semble d&eacute;j&agrave; exister avec ce nom et pr&eacute;nom.
            <br>
            Êtes-vous s&ucirc;r de vouloir cr&eacute;er cet auteur ?
          </p>
          <p class="inversed">
            L'auteur `<span class="modal_auteur"></span>` semble d&eacute;j&agrave; exister, mais avec nom et pr&eacute;nom invers&eacute;s.
            <br>
            Pensez-vous avoir commis une &eacute;tourderie sur ce point ?
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
              <a href="{{ url('/search#auteur_recherche_directe') }}"><i class="fa fa-angle-right"></i>&nbsp;Rechercher un auteur</a>
              <h2>Auteurs enregistr&eacute;es</h2>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Pr&eacute;nom</th>
                      <th>&Eacute;quipe</th>
                      <th>Publications</th>
                      @if (Auth::user() && Auth::user()->is_admin)
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($organisations as $organisation)
                      <tr class="active">
                        <th colspan="5"><strong><a href="{{ url('/organisations/show/'.$organisation->id) }}">{{ $organisation->nom }} ({{ $organisation->etablissement }})</a></strong></th>
                      </tr>
                      @foreach ($organisation->equipes as $equipe)
                        @foreach ($equipe->auteurs as $auteur)
                          <tr>
                            <td><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ strtoupper($auteur->nom) }}</a></td>
                            <td><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }}</a></td>
                            <td><a href="{{ url('/equipes/show/'.$equipe->id) }}">{{ $equipe->nom }}</a></td>
                            <td>{{ count($auteur->publications) }}</td>
                            @if (Auth::user() && Auth::user()->is_admin)
                            <td class="text-right">
                              <form action="{{ url('auteurs/'.$auteur->id) }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}

                                <a href="{{ url('/auteurs/edit/'.$auteur->id) }}" class="btn btn-xs btn-default"><i class="fa fa-cogs"></i></a>
                                <button title="Supprimer" type="submit" class="btn btn-danger btn-xs">
                                  <i class="fa fa-btn fa-trash"></i>
                                </button>
                              </form>
                            </td>
                            @endif
                          </tr>
                        @endforeach
                      @endforeach
                      @if (count($organisation->auteurs) === 0)
                        <tr>
                          <td colspan="5">Pas d'auteurs pour cette organisation</td>
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
              <h2>Ajouter un auteur</h2>
              <form class="js-validate manual-validate" action="{{ url('/auteurs') }}" method="POST" role="form">
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
                      <i class="fa fa-fw fa-tags"></i>
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
        @endif
    </section>

    <script>
    var auteursList = [
      @foreach ($organisations as $organisation)
        @foreach ($organisation->auteurs as $auteur)
          { nom: "{!! $auteur->nom !!}", prenom: "{!! $auteur->prenom !!}" },
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
          var inversed = false;

          var newNom = $('input[name="nom"]').val();
          var newPrenom = $('input[name="prenom"]').val();

          for (var i = 0, len = auteursList.length; i < len; i++) {
            if (auteursList[i].nom.toLowerCase() === newNom.toLowerCase() &&
                auteursList[i].prenom.toLowerCase() === newPrenom.toLowerCase()) {
                  duplicate = true;
            } else if (auteursList[i].nom.toLowerCase() === newPrenom.toLowerCase() &&
                       auteursList[i].prenom.toLowerCase() === newNom.toLowerCase()) {
                  inversed = true;
            }
          }

          if (duplicate || inversed) {
            $('.modal_auteur').text(newNom + " " + newPrenom);
            $('#duplicateModal').modal('show');

            if (inversed) {
              $('#duplicateModal .duplicate').hide();
              $('#duplicateModal .inversed').show();
            }
            if (duplicate) {
              $('#duplicateModal .duplicate').show();
              $('#duplicateModal .inversed').hide();
            }
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

@section('title', 'Auteurs')
