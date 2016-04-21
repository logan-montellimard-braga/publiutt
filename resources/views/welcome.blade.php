@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
  <header class="main">
    <div class="container">
      <div class="wrapper"></div>
      <div class="dark"></div>
      <div class="content">
        <div class="row">
          <div class="col-sm-12">
            <h1>Publi<b>UTT</b></h1>
            <span>La biblioth&egrave;que des publications scientifiques</span>
            <div class="clearfix"></div>
            <span>par les chercheurs de l'UTT</span>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 action">
            @if (Auth::guest())
              <a href="{{ url('/login') }}"><i class="fa fa-angle-right"></i>&nbsp;Je suis chercheur &agrave; l'UTT</a>
            @else
              <a href=""><i class="fa fa-angle-right"></i>&nbsp;J'ajoute une publication</a>
            @endif
          </div>
        </div>
      </div>
      <div class="bottom-content to-content">
        <div class="row">
          <div class="col-sm-12">
            <i class="fa fa-angle-double-down"></i>
          </div>
        </div>
      </div>
    </div>
  </header>
@endsection
