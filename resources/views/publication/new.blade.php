@extends('layouts.app')
@section('title', 'Nouvelle publication')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <a href="{{ url('/publications') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux publications</a>
        <h2>Ajouter une publication</h2>

        <form id="add" action="{{ url('/publications') }}" method="POST" role="form" enctype="multipart/form-data">
          {!! csrf_field() !!}

          <div class="form-group{{ $errors->has('titre') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-pencil"></i>
              </div>
              <input required name="titre" type="text" class="form-control input-lg" value="{{ old('titre') }}" placeholder="Titre de la publication...">
            </div>
            @if ($errors->has('titre'))
            <span class="help-block">
              <strong>{{ $errors->first('titre') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-hashtag"></i>
              </div>
              <input required name="reference" type="text" class="form-control input-lg" value="{{ old('reference') }}" placeholder="R&eacute;f&eacute;rence...">
            </div>
            @if ($errors->has('reference'))
            <span class="help-block">
              <strong>{{ $errors->first('reference') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('annee') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-calendar-o"></i>
              </div>
              <input required name="annee" type="number" class="form-control input-lg" value="{{ old('annee') }}" placeholder="Ann&eacute;e de publication...">
            </div>
            @if ($errors->has('annee'))
            <span class="help-block">
              <strong>{{ $errors->first('annee') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('categorie') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-folder-open"></i>
              </div>
              <select required class="form-control" name="categorie">
                <option selected disabled>Cat&eacute;gorie de la publication</option>
                @foreach ($categories as $categorie)
                  <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
              </select>
            </div>
            @if ($errors->has('categorie'))
            <span class="help-block">
              <strong>{{ $errors->first('categorie') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('statut') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-flag"></i>
              </div>
              <select required class="form-control" name="statut">
                <option selected disabled>Statut de la publication</option>
                @foreach ($statuts as $statut)
                  <option value="{{ $statut->id }}">{{ $statut->nom }}</option>
                @endforeach
              </select>
            </div>
            @if ($errors->has('statut'))
            <span class="help-block">
              <strong>{{ $errors->first('statut') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-file"></i>
              </div>
              <span class="btn btn-default btn-file btn-lg btn-block">
                <span class="filename">S&eacute;lectionner un document...</span> <input id="file_select" required name="document" type="file">
              </span>
            </div>
            @if ($errors->has('document'))
            <span class="help-block">
              <strong>{{ $errors->first('document') }}</strong>
            </span>
            @endif
          </div>

          <input type="hidden" id="auteurs" name="auteurs" />

          <div class="form-group{{ $errors->has('auteurs') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-users"></i>
              </div>
              <select id="auteurs_ms" multiple rows="10" class="form-control" name="auteurs_ms[]">
                @foreach ($organisations as $organisation)
                  @foreach ($organisation->equipes as $equipe)
                    @foreach ($equipe->auteurs as $auteur)
                      <option value="{{ $auteur->id }}">{{ strtoupper($auteur->nom) }} {{ $auteur->prenom }} - {{ $equipe->nom }}</option>
                    @endforeach
                  @endforeach
                @endforeach
              </select>
            </div>
            <a href="{{ url('/auteurs#add') }}"><i class="fa fa-angle-right"></i>&nbsp;Un des auteurs n'est pas encore enregistr&eacute; ?</a>
            @if ($errors->has('auteurs'))
            <span class="help-block">
              <strong>{{ $errors->first('auteurs') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="checkbox checkbox-primary">
                <input name="is_conference" id="is_conference" class="styled" type="checkbox" {{ old('is_conference') ? 'checked' : '' }}>
                <label for="is_conference">
                  La publication est une conf&eacute;rence
                </label>
              </div>
            </div>
          </div>

          <div id="lieu" class="form-group{{ $errors->has('lieu') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-map-marker"></i>
              </div>
              <input name="lieu" type="text" class="form-control input-lg" value="{{ old('lieu') }}" placeholder="Lieu de la conf&eacute;rence...">
            </div>
            @if ($errors->has('lieu'))
            <span class="help-block">
              <strong>{{ $errors->first('lieu') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
  window.jqReady = function() {
    $('#auteurs_ms').multiSelect({
        keepOrder: true,
        selectableHeader: "<div class='ms-header'>Auteurs disponibles</div>",
        selectionHeader: "<div class='ms-header'>Auteurs de la publication</div>",
    });

    $('#add').submit(function() {
        var selections = [];
        var sels = $('#ms-auteurs_ms .ms-selection .ms-list li:visible');
        $.each(sels, function(i, el) {
          var str = $(el).find('span').text();
          var opt = $('form option:contains("' + str + '")');
          $.each(opt, function(j, ell) {
            selections.push($(ell).attr('value'));
          });
        });
        $('#auteurs').val(selections);
    })

    $('#lieu').hide();
    $('#file_select').change(function() {
        var name = $('#file_select').val().split('\\');
        name = name[name.length - 1];
        $('form .filename').text(name);
    });
    $('#is_conference').change(function() {
      if ($(this).is(':checked')) {
        $('#lieu').fadeIn(300);
      } else {
        $('#lieu').val('');
        $('#lieu').fadeOut(300);
      }
    })
  };
  </script>
  @endsection