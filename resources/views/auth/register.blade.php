@extends('layouts.app')

@section('title', 'Inscription')
@section('body-class', 'auth')

@section('content')
<section class="background full flex-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 bloc-form">
                <h1 class="title"><a href="{{ url('/') }}">Publi<b>UTT</b></a></h1>
                <form role="form" method="POST" action="{{ url('/register') }}" class="js-validate">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="input-group input-group-lg">
                          <div class="input-group-addon">
                            <i class="fa fa-fw fa-envelope"></i>
                          </div>
                          <input autofocus required name="email" type="email" class="form-control input-lg" value="{{ old('email') }}" placeholder="Adresse e-mail...">
                        </div>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-lock"></i>
                        </div>
                        <input required name="password" type="password" class="form-control input-lg" placeholder="Mot de passe...">
                      </div>
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-lock"></i>
                        </div>
                        <input required name="password_confirmation" type="password" class="form-control input-lg" placeholder="Confirmation du mot de passe...">
                      </div>
                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                    </div>

                    <br>

                    <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-tag"></i>
                        </div>
                        <input required type="text" name="nom" value="{{ old('nom') }}" class="form-control input-lg" placeholder="Nom...">
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
                        <input required type="text" name="prenom" value="{{ old('prenom') }}" class="form-control input-lg" placeholder="Prénom...">
                      </div>
                      @if ($errors->has('nom'))
                          <span class="help-block">
                              <strong>{{ $errors->first('prenom') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-university"></i>
                        </div>
                        <select class="form-control" disabled>
                          <option selected>{{ $etablissement }}</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group{{ $errors->has('equipe') ? ' has-error' : '' }}">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-flask"></i>
                        </div>
                        <select class="form-control" name="equipe">
                          <option selected disabled>&Eacute;quipe de recherche</option>
                          @foreach ($equipes as $equipe)
                            <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                          @endforeach
                        </select>
                      </div>
                      @if ($errors->has('equipe'))
                          <span class="help-block">
                              <strong>{{ $errors->first('equipe') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-right">
                      <button type="submit" class="up-small btn btn-lg btn-theme">Inscription</button>
                    </div>
                </form>
                <p class="text-left">
                  <a href="{{ url('/login') }}"><i class="fa fa-angle-right"></i>&nbsp;D&eacute;j&agrave; inscrit ?</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
