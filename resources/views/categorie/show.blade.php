@extends('layouts.app')

@section('title', 'Catégorie ' . $categorie->initials())

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-8 col-sm-9">
          <a href="{{ url('/publications') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux publications</a>
          <h2>Publications cat&eacute;goris&eacute;es <em>{{ $categorie->nom }}</em></h2>
          @if ($publications->total() == 0)
            <p>Aucune publication.</p>
          @else
            <p>{{ $publications->total() }} publications :</p>
          @endif

          <ul class="publications">
            @foreach ($publications as $publication)
              <li>@include('publication.publication')</li>
            @endforeach
          </ul>
          <div class="text-center">
            {!! $publications->links() !!}
          </div>
        </div>
        <div class="col-md-4 col-sm-3 text-right">
          <h3>Cat&eacute;gories</h3>
          <ul>
            @foreach ($categories as $ct)
              @if ($ct->id === $categorie->id)
                <li><b><a href="{{ url('/categories/show/'.$ct->id) }}">{{ $ct->nom }}</a></b></li>
              @else
                <li><a href="{{ url('/categories/show/'.$ct->id) }}">{{ $ct->nom }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
