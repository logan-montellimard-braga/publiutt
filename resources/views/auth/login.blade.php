@extends('layouts.app')

@section('content')
<section class="background full flex-center">
  <div class="container">
      <div class="row">
          <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 bloc-form">
              <h1 class="title"><a href="{{ url('/') }}">Publi<b>UTT</b></a></h1>
              <form role="form" method="POST" action="{{ url('/login') }}">
                  {!! csrf_field() !!}

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">
                          <i class="fa fa-fw fa-envelope"></i>
                        </div>
                        <input name="email" type="email" class="form-control input-lg" value="{{ old('email') }}" placeholder="Adresse e-mail...">
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
                      <input name="password" type="password" class="form-control input-lg" placeholder="Mot de passe...">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group text-right">
                    <button type="submit" class="up-small btn btn-lg btn-theme">Connexion</button>
                  </div>
              </form>
              <p class="text-left">
                <a href="{{ url('/register') }}"><i class="fa fa-angle-right"></i>&nbsp;Pas encore de compte ?</a>
              </p>
          </div>
      </div>
  </div>
</section>
@endsection