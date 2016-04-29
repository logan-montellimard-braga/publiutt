<div class="publication panel panel-primary">
  <div class="panel-heading">
    <div class="row">
      <div class="col-sm-10">
        <a href="{{ url('/categories/show/'.$publication->categorie->id) }}" title="{{ $publication->categorie->nom }}" class="badge tooltip-on">{{ $publication->categorie->initials() }}</a>&nbsp;<a href="{{ url('/publications/show/'.$publication->id) }}">{{ $publication->titre }}</a>
      </div>
      <div class="hidden-xs col-sm-2 text-right">
        <i class="publi-collapse fa fa-fw fa-minus" data-toggle="collapse" data-target="#publi_{{ $publication->id }}" aria-expanded="true" aria-controls="publi_{{ $publication->id }}"></i>
      </div>
    </div>
  </div>
  <div class="collapse in" id="publi_{{ $publication->id }}">
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-7">
          <p><span title="Référence">{{ $publication->reference }}</span>, <span title="Année de publication" class="date">{{ date('Y', strtotime($publication->annee)) }}</span>
              @if ($publication->lieu)
                - {{ $publication->lieu }}
              @endif
          </p>
        </div>
        <div class="col-sm-5 hidden-xs text-right">
          <p>
            <span title="Statut de la publication"><a href="{{ url('/statuts/show/'.$publication->statut->id) }}">{{ $publication->statut->nom }}</a></span>
          </p>
        </div>
      </div>
    </div>
    <div class="panel-footer hidden-xs">
      <div class="row">
        <div class="col-xs-10">
          <ul class="authors">
            @foreach ($publication->auteurs()->withPivot('ordre')->orderBy('ordre')->get() as $auteur)
              @if ($auteur->isChercheurUTT())
                <li><a class="tooltip-on badge" title="{{ $auteur->equipe->nom }} ({{ $auteur->organisation->nom }})" href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a></li>
              @else
                <li><a class="tooltip-on badge" title="{{ $auteur->equipe->nom }} ({{ $auteur->organisation->nom }})" href="{{ url('/auteurs/show/'.$auteur->id) }}"><i class="fa fa-fw fa-globe"></i>&nbsp;{{ $auteur->prenom }} {{ $auteur->nom }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
        <div class="col-xs-2 text-right">
          <a data-placement="left" title="Télécharger" class="tooltip-on download-button" download="{{ $publication->document }}" href="{{ url('/upload/'.$publication->document) }}"><i class="fa fa-cloud-download fa-fw"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
