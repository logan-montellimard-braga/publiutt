<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Publi'UTT &middot; Accueil</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" href="tile.png">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ asset('css/normalize.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/loaders.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
</head>
<body class="{{ strpos(Route::getCurrentRoute()->getActionName(), 'Auth') ? 'auth' : '' }}">
  <!--[if lt IE 9]>
    <div class="browserupgrade alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
      <p>Vous utilisez un navigateur <strong>obsol&egrave;te</strong>. Rendez-vous sur <a href="http://browsehappy.com/">ici</a> pour am&eacute;liorer votre exp&eacute;rience de navigation.</p>
    </div>
  <![endif]-->

  <div id="loader">
    <div class="loader-wrap">
      <div class="loader-inner ball-scale-multiple">
        <div></div><div></div><div></div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Afficher navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Publi<b>UTT</b></a>
          </div>

          <div class="nav navbar-nav hidden-xs hidden-sm">
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Chercher un article...">
              </div>
              <button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
            </form>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="{{ Route::getCurrentRoute()->getName() === 'root' ? 'active' : '' }}"><a href="{{ url('/') }}">Accueil</a></li>
              <li><a href="#">Publications</a></li>
              @if (Auth::guest())
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace membre&nbsp;<i class="fa fa-angle-down"></i></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('/login') }}">Se connecter</a></li>
                    <li><a href="{{ url('/register') }}">S'inscrire</a></li>
                  </ul>
                </li>
              @else
                <li><a href="{{ url('/logout') }}">D&eacute;connexion</a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  @yield('content')

  <footer>
    <div class="top">
      <div class="container">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="links col-sm-4">
            </div>
            <div class="links col-sm-4">
            </div>
            <div class="links col-sm-4">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-sm-offset-1">
            <a href="{{ url('/') }}" class="brand">Publi<b>UTT</b></a>
            <span class="clearfix"></span>
            <a class="author" target="_blank" href="http://loganbraga.fr">Logan Braga</a>
            <a class="author" target="_blank" href="#">Peirun Yu</a>
          </div>
          <div class="col-sm-4 copyright">
            <p>&copy; {{ date('Y') }} - Tous droits r&eacute;serv&eacute;s</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script>window.jQuery || document.write("<script src=\"{{ asset('js/vendor/jquery-1.11.2.min.js') }}\"><\/script>")</script>
  <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
