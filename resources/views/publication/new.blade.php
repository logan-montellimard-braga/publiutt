@extends('layouts.app')
@section('title', 'Nouvelle publication')

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
            La publication `<span class="modal_publication"></span>` semble d&eacute;j&agrave; exister avec ce titre.
            <br>
            Êtes-vous s&ucirc;r de vouloir cr&eacute;er cette publication ?
          </p>
          <p class="duplicate_conference">
            La conf&eacute;rence `<span class="modal_publication"></span>` semble d&eacute;j&agrave; exister sur <span class="modal_lieu"></span>.
            <br>
            Êtes-vous certain de vouloir cr&eacute;er cette conf&eacute;rence ?
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
        <a href="{{ url('/publications') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux publications</a>
        <h2>Ajouter une publication</h2>

        <form id="add" action="{{ url('/publications') }}" method="POST" role="form" enctype="multipart/form-data" class="js-validate manual-validate">
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
          <input type='text' class='input-sm search-input form-control' autocomplete='off' placeholder='Filtrer les auteurs disponibles...'>

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

          <div class="hidden-xs hidden-sm hidden-md hidden-lg form-group">
            <div class="input-group input-group-lg">
              <div class="checkbox checkbox-primary">
                <input name="is_conference" id="is_conference" class="styled" type="checkbox" {{ old('is_conference') ? 'checked' : '' }}>
              </div>
            </div>
          </div>

          <div class="form-group text-right">
            <button type="submit" class="up-small btn btn-lg btn-theme">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
  var pubList = [
    @foreach ($organisations as $organisation)
      @foreach ($organisation->auteurs as $auteur)
        @foreach ($auteur->publications as $publication)
            { titre: "{!! $publication->titre !!}", lieu: "{!! $publication->lieu !!}" },
        @endforeach
      @endforeach
    @endforeach
  ];

  window.jqReady = function(config) {
    $.getScript('/js/vendor/jquery.quicksearch.min.js', function() {
      $('#auteurs_ms').multiSelect({
        keepOrder: true,
        selectableHeader: "<div class='ms-header'>Auteurs disponibles</div>",
        selectionHeader: "<div class='ms-header'>Auteurs de la publication</div>",
        afterInit: function(ms){
          var that = this,
              $selectableSearch = $('.search-input'),
              selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)';

          that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
          .on('keydown', function(e){
            if (e.which === 40){
              that.$selectableUl.focus();
              return false;
            }
          });
        },
        afterSelect: function(){
          this.qs1.cache();
        },
        afterDeselect: function(){
          this.qs1.cache();
        }
      });
    });

    $('#modal_ok').click(function() {
      $('#modal_ok').attr('data-ok', 'true');
      $('section form').submit();
    });

    var conf = config.validation;
    conf.submitHandler = function(form) {
    if (!($('#is_conference').is(':checked')))
      $('[name="lieu"]').val(null);

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


      if ($('#modal_ok').attr('data-ok') == 'true') form.submit();
      var duplicate = false;
      var duplicate_conference = false;

      var newTitre = $('input[name="titre"]').val();
      var newLieu = $('input[name="lieu"]').val();
      var isConf = $('[name="is_conference"]').is(':checked');

      for (var i = 0, len = pubList.length; i < len; i++) {
        if (isConf && pubList[i].titre.toLowerCase() === newTitre.toLowerCase() &&
            pubList[i].lieu.toLowerCase() === newLieu.toLowerCase()) {
              duplicate_conference = true;
            } else if (pubList[i].titre.toLowerCase() === newTitre.toLowerCase()) {
              duplicate = true;
            }
      }

      if (duplicate || duplicate_conference) {
        $('.modal_publication').text(newTitre);
        $('#duplicateModal').modal('show');

        if (duplicate_conference) {
          $('.modal_lieu').text(newLieu);
          $('#duplicateModal .duplicate').hide();
          $('#duplicateModal .duplicate_conference').show();
        }
        if (duplicate) {
          $('#duplicateModal .duplicate').show();
          $('#duplicateModal .duplicate_conference').hide();
        }
      } else {
        form.submit();
      }
      return false;
    };

    $('#add').validate(conf);

    if (!($('#is_conference').is(':checked'))) $('#lieu').hide();
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
    });
    $('[name="categorie"]').change(function() {
        var label = $($('[value="' + this.value + '"]')[0]).text();
        if (label.toLowerCase().indexOf("conférence") > -1) {
            $('#is_conference').prop('checked', true);
            $('#is_conference').change();
        } else {
            $('#is_conference').prop('checked', false);
            $('#is_conference').change();
        }
    });
  };
  </script>
  @endsection
