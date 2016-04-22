@extends('layouts.app')
@section('title', 'Nouvelle publication')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h2>Ajouter une publication</h2>

        <form action="{{ url('/publications') }}" method="POST" role="form">
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

          <div class="form-group{{ $errors->has('statut') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-flag"></i>
              </div>
              <select class="form-control" name="statut">
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
