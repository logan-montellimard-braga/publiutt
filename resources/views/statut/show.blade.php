@extends('layouts.app')

@section('title', 'Statut ' . $statut->nom)

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-9 col-sm-8">
          <a href="{{ url('/publications') }}"><i class="fa fa-angle-left"></i>&nbsp;Retour aux publications</a>
          <h2>Publications au statut <em>{{ $statut->nom }}</em></h2>
          @if ($publications->total() == 0)
            <p>Il n'y a pas encore de publications avec ce statut.</p>
          @else
            <p>{{ $publications->total() }} publications.</p>
            <p>
                <a href="" class="publi-collapse-all"><i class="fa fa-fw fa-minus"></i>&nbsp;Tout minimiser</a>
                <a href="" class="publi-expand-all"><i class="fa fa-fw fa-plus"></i>&nbsp;Tout maximiser</a>
            </p>
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
        <div class="col-md-3 col-sm-4">
          <h3>Statuts</h3>
          <ul>
            @foreach ($statuts as $st)
              @if ($st->id === $statut->id)
                <li>
                  <span title="{{ count($st->publications) }} publications" class="badge">{{ count($st->publications) }}</span>
                  <a title="{{ count($st->publications) }} publications avec le statut {{ $st->nom }}" href="{{ url('/statuts/show/'.$st->id) }}"><b>{{ $st->nom }}</b></a>
                </li>
              @else
                <li>
                  <span title="{{ count($st->publications) }} publications" class="badge">{{ count($st->publications) }}</span>
                  <a title="{{ count($st->publications) }} publications avec le statut {{ $st->nom }}" href="{{ url('/statuts/show/'.$st->id) }}">{{ $st->nom }}</a>
                </li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
