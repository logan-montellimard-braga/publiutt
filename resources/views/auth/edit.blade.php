@extends('layouts.app')
@section('title', 'Modifier le profil')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <a href="{{ url('/profil') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour au profil</a>
        <h2>Modification du profil</h2>
        <br>
        <form class="js-validate" role="form" method="POST" action="{{ url('/users/edit/'.$user->id) }}">
          {!! csrf_field() !!}
          {!! method_field('PATCH') !!}

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-envelope"></i>
              </div>
              <input autofocus required name="email" type="email" class="form-control input-lg" value="{{ old('email', $user->email) }}" placeholder="Adresse e-mail...">
            </div>
            @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div>

          <a href="#change_pass" data-toggle="collapse" aria-expanded="false" aria-controls="change_pass"><i class="fa fa-angle-right"></i>&nbsp;Je veux changer mon mot de passe</a>
          <br>
          <br>
          @if ($errors->has('password') || $errors->has('password_confirmation') || $errors->has('old_password'))
            <div class="collapse in" id="change_pass">
          @else
            <div class="collapse" id="change_pass">
          @endif
          <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-unlock"></i>
              </div>
              <input name="old_password" type="password" class="form-control input-lg" placeholder="Ancien mot de passe...">
            </div>
            @if ($errors->has('old_password'))
            <span class="help-block">
              <strong>{{ $errors->first('old_password') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-lock"></i>
              </div>
              <input name="password" type="password" class="form-control input-lg" placeholder="Nouveau mot de passe...">
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
              <input name="password_confirmation" type="password" class="form-control input-lg" placeholder="Confirmation du nouveau mot de passe...">
            </div>
            @if ($errors->has('password_confirmation'))
            <span class="help-block">
              <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
          </div>
          </div>

          <br>

          <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
            <div class="input-group input-group-lg">
              <div class="input-group-addon">
                <i class="fa fa-fw fa-tag"></i>
              </div>
              <input required type="text" name="nom" value="{{ old('nom', $auteur->nom) }}" class="form-control input-lg" placeholder="Nom...">
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
              <input required type="text" name="prenom" value="{{ old('prenom', $auteur->prenom) }}" class="form-control input-lg" placeholder="Prénom...">
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
                  @if ($auteur->equipe == $equipe)
                    <option selected value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                  @else
                    <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                  @endif
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
            <button type="submit" class="up-small btn btn-lg btn-theme">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection('content')
