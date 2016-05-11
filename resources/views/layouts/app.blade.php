<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie10 lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9" lang="fr"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="fr"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PubliUTT &middot; @yield('title')</title>

  <meta name="keywords" content="publiutt,utt,troyes,publications,chercheurs,science,laboratoire">
  <meta name="description" content="PubliUTT, la bibliothèque des publications scientifiques par les chercheurs de l'UTT.">
  <meta name="author" content="Logan BRAGA, contact@loganbraga.fr; Peirun YU, peirun.yu@utt.fr">

  <link rel="copyright" href="LICENSE">
  <link rel="author" href="humans.txt">

  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/tile.png">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ asset('css/normalize-4.1.1.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/loaders.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main-autoprefixer.css') }}">

  <script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
     (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-60715874-5', 'auto');ga('send', 'pageview');
  </script>
</head>
<body class="@yield('body-class')">
  <!--[if lt IE 9]>
    <div class="browserupgrade alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
      <p>Vous utilisez un navigateur <strong>obsol&egrave;te</strong>. Rendez-vous <a href="http://browsehappy.com/">ici</a> pour am&eacute;liorer votre exp&eacute;rience de navigation.</p>
    </div>
  <![endif]-->

  <div class="no-js-alert alert alert-danger">
    <p>Nous recommandons l'activation de <strong>JavaScript</strong> dans votre navigateur pour une exp&eacute;rience optimale.</p>
  </div>
  <style>.no-js-alert{display:none;} .no-js .no-js-alert{display:block;}</style>

  <div id="loader" style="display: none;">
    <div class="loader-wrap">
      <div class="loader-inner ball-scale-multiple">
        <div></div><div></div><div></div>
      </div>
    </div>
  </div>
  <script>
    var loader = document.getElementById('loader');
    loader.style.webkitDisplay = 'box';
    loader.style.webkitDisplay = 'flex';
    loader.style.msDisplay = 'flexbox';
    loader.style.display = 'flex';
    document.body.style.overflowY = 'hidden';
  </script>

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
            <form class="navbar-form navbar-left" role="search" action="{{ url('/search/results') }}" method="GET">
              {!! csrf_field() !!}
              <div class="form-group">
                <input required name="query_v" type="text" class="form-control" placeholder="Rechercher..." value="@yield('search_query')">
                <input type="hidden" name="s_type" value="query">
              </div>
              <button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
            </form>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="{{ Route::getCurrentRoute()->getName() === 'root' ? 'active' : '' }}"><a href="{{ url('/') }}">Accueil</a></li>
              <li class="{{ 0 === strpos(Route::getCurrentRoute()->getName(), 'publications') ? 'active' : '' }}"><a href="{{ url('/publications') }}">Publications</a></li>
              @if (Auth::guest())
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace membre&nbsp;<i class="fa fa-angle-down"></i></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('/login') }}">Se connecter</a></li>
                    <li><a href="{{ url('/register') }}">S'inscrire</a></li>
                  </ul>
                </li>
              @else
                <li class="dropdown">
                  @if (Auth::user()->auteur != null)
                    @if (Auth::user()->is_admin)
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge tooltip-on" title="Administrateur" data-placement="bottom"><i class="fa fa-star"></i></span>&nbsp;{{ Auth::user()->auteur->prenom }} {{ Auth::user()->auteur->nom }}&nbsp;<i class="fa fa-angle-down"></i></span></a>
                    @else
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->auteur->prenom }} {{ Auth::user()->auteur->nom }}&nbsp;<i class="fa fa-angle-down"></i></span></a>
                    @endif
                  @else
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->email }}&nbsp;<i class="fa fa-angle-down"></i></span></a>
                  @endif
                  <ul class="dropdown-menu">
                    <li class="{{ Route::getCurrentRoute()->getName() === 'dashboard' ? 'active' : '' }}"><a href="{{ url('/dashboard') }}">Tableau de bord</a></li>
                    <li class="{{ 0 === strpos(Route::getCurrentRoute()->getName(), 'profil') ? 'active' : '' }}"><a href="{{ url('/profil') }}">Mon profil</a></li>
                    <li><a href="{{ url('/logout') }}">D&eacute;connexion</a></li>
                  </ul>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  @if(Session::has('flash_message'))
    <div class="alert alert-success alert-dismissible">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <span class="fa fa-check"></span>&nbsp;{!! session('flash_message') !!}
    </div>
  @endif
  @if(Session::has('flash_message_error'))
    <div class="alert alert-danger alert-dismissible">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <span class="fa fa-exclamation-triangle"></span>&nbsp;{!! session('flash_message_error') !!}
    </div>
  @endif

  @if (Route::getCurrentRoute()->getName() !== 'root')
    <header id="band">
      <h1>@yield('title')</h1>
    </header>
  @endif

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
            <div class="clearfix"></div>
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
  <script src="{{ asset('js/vendor/jquery.placeholder.min.js') }}"></script>
  <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/vendor/jquery.multi-select.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
