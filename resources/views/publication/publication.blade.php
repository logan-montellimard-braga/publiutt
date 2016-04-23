<div class="publication">
    <h4><span title="{{ $publication->categorie->nom }}" class="badge tooltip-on">{{ $publication->categorie->initials() }}</span>&nbsp;<a href="{{ url('/publications/show/'.$publication->id) }}">{{ $publication->titre }}</a></h4>
    <h6>{{ $publication->reference }}, <span class="date">{{ date('Y', strtotime($publication->annee)) }}</span></h6>
    <ul class="authors">
    @foreach ($publication->auteurs()->withPivot('ordre')->orderBy('ordre')->get() as $auteur)
        <li><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a></li>
    @endforeach
    </ul>
</div>
