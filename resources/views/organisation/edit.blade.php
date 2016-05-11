@extends('layouts.app')
@section('title', 'Modifier une organisation')


@section('content')
<section>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="row">
        <div class="col-sm-12">
          <a href="{{ url('/organisations/show/'.$organisation->id) }}"><i class="fa fa-angle-left"></i>&nbsp;Retour &agrave; l'organisation</a>
        </div>
        <p class="clearfix visible-xs"></p>
      </div>
      <h2>Modifier l'organisation</h2>
      <form class="js-validate" action="{{ url('/organisations/edit/'.$organisation->id) }}" method="POST" role="form">
        {!! csrf_field() !!}
        {!! method_field('PATCH') !!}

        <div class="form-group{{ $errors->has('institut') ? ' has-error' : '' }}">
          <div class="input-group input-group-lg">
            <div class="input-group-addon">
              <i class="fa fa-fw fa-flask"></i>
            </div>
            <input required name="institut" type="text" class="form-control input-lg" value="{{ old('institut', $organisation->nom) }}" placeholder="Institut de recherche...">
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
            <input required name="etablissement" type="text" class="form-control input-lg" value="{{ old('etablissement', $organisation->etablissement) }}" placeholder="&Eacute;tablissement...">
          </div>
          @if ($errors->has('etablissement'))
          <span class="help-block">
            <strong>{{ $errors->first('etablissement') }}</strong>
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
