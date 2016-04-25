<h2>Administration</h2>
<br>
<div>
  <ul id="admin_tabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#comptes" aria-controls="comptes" role="tab" data-toggle="tab"><i class="fa fa-users fa-fw"></i>&nbsp;Comptes</a></li>
    <li role="presentation"><a href="#anomalies" aria-controls="anomalies" role="tab" data-toggle="tab"><i class="fa fa-bug fa-fw"></i>&nbsp;Anomalies</a></li>
    <li role="presentation"><a href="#statistiques" aria-controls="statistiques" role="tab" data-toggle="tab"><i class="fa fa-bar-chart fa-fw"></i>&nbsp;Statistiques</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="comptes">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <br>
          <h4>Comptes utilisateurs</h4>
          <p>Il y a <b>{{ count($comptes) }} comptes</b> utilisateurs inscrits.</p>
          <br>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>E-Mail</th>
                  <th>Administrateur ?</th>
                  <th>Auteur associ&eacute;</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($comptes as $compte)
                  <tr>
                    <td>{{ $compte->email }}</td>
                    <td>
                      <form action="{{ url('users/switch_admin/'.$compte->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('PATCH') !!}

                        @if ($compte->is_admin)
                          <button {{ Auth::user()->id === $compte->id ? 'disabled' : '' }} title="Révoquer privilège administrateur" type="submit" class="btn btn-default btn-sm">
                            <i class="fa fa-toggle-on fa-fw"></i>
                          </button>
                        @else
                          <button title="Ajouter privilège administrateur" type="submit" class="btn btn-default btn-sm">
                            <i class="fa fa-toggle-off fa-fw"></i>
                          </button>
                        @endif
                      </form>
                    </td>
                    <td><a href="{{ url('/auteurs/show/'.$compte->auteur->id) }}">{{ $compte->auteur->prenom}} {{ $compte->auteur->nom }}</a> <a href="{{ url('/equipes/show/'.$compte->auteur->equipe->id) }}"><abbr title="{{ $compte->auteur->equipe->description }}">({{ $compte->auteur->equipe->nom }})</abbr></a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="anomalies">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <br>
          <h4>Auteurs potentiellement en doublon</h4>
          @if (count($auteurs_doublons) > 0)
            <p>
              Liste des auteurs ayant au moins deux entr&eacute;es avec le m&ecirc;me nom et pr&eacute;nom :
            </p>
            <br>
            <ul class="intact">
              @foreach ($auteurs_doublons as $doublon)
                <li>{{ $doublon->prenom }} {{ $doublon->nom }}</li>
              @endforeach
            </ul>
          @else
            <p>Il n'y a pas d'auteurs en doublon.</p>
          @endif

          <br>
          <hr>

          <br>
          <h4>Publications avec auteurs en doublon</h4>
          @if (count($doublons_auteurs) > 0)
            <p>
              Liste des publications ayant un ou des auteurs en doublon :
            </p>
            <br>
            <ul>
              @foreach ($doublons_auteurs as $publication)
                @include('publication.publication')
              @endforeach
            </ul>
          @else
            <p>Il n'y a pas de publications avec auteurs en doublon.</p>
          @endif

          <br>
          <hr>
          <br>

          <br>
          <h4>Publications potentiellement en doublon</h4>
          @if (count($doublons) > 0)
            <p>
              Liste des publications ayant au moins 2 entr&eacute;es avec le m&ecirc;me titre et la m&ecirc;me ann&eacute;e de publication :
            </p>
            <br>
            <ul>
              @foreach ($doublons as $publication)
                @include('publication.publication')
              @endforeach
            </ul>
          @else
            <p>Il n'y a pas de publications en doublon.</p>
          @endif

          <br>
          <hr>
          <br>

          <h4>Publications hors-UTT</h4>
          @if (count($publications_ext) > 0)
            <p>
              Liste des publications dont aucun auteur n'est chercheur &agrave; l'UTT :
            </p>
            <br>
            <ul>
              @foreach ($publications_ext as $publication)
                @include('publication.publication')
              @endforeach
            </ul>
          @else
            <p>Il n'y a pas de publications dont aucun auteur n'est chercheur &agrave; l'UTT.</p>
          @endif
        </div>
      </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="statistiques">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <br>
          <h4>Informations</h4>
          <p>
            Il y a <b>{{ count($publications) }} publications</b> pour un total de <b>{{ count($auteurs_perf) }} chercheurs</b>.
          </p>
          <br>
          <h4>Performance des chercheurs</h4>
          <br>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Score</th>
                  <th>Chercheur</th>
                  <th>&Eacute;quipe</th>
                  <th>Organisation</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($auteurs_perf as $auteur)
                <tr>
                  <td>{{ $auteur->getPerformanceScore() }}</td>
                  <td><a href="{{ url('/auteurs/show/'.$auteur->id) }}">{{ $auteur->prenom }} {{ $auteur->nom }}</a></td>
                  <td><a href="{{ url('/equipes/show/'.$auteur->equipe->id) }}">{{ $auteur->equipe->nom }}</a></td>
                  <td><a href="{{ url('/organisations/show/'.$auteur->organisation->id) }}">{{ $auteur->organisation->nom }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <p>
            Un score est calcul&eacute; pour chaque enseignant selon ses publications et ses collaborateurs.
            <br>
            <a role="button" data-toggle="collapse" href="#regles" aria-expanded="false" aria-controls="regles"><i class="fa fa-angle-right"></i>&nbsp;Afficher les r&egrave;gles</a>
          </p>
          <div class="collapse" id="regles">
            <div class="well">
              <ul class="intact">
                <li><u>&Eacute;crire ou mourir</u> : Être auteur ou co-auteur d'une publication rapporte <b>100 points</b></li>
                <li><u>Un peu d'ordre</u> : Un bonus de <b>100 points</b> divis&eacute;s par la <em>position dans la liste des auteurs de la publication</em> est ajout&eacute;</li>
                <li><u>Publi&eacute; c'est gagn&eacute;</u> : Si la publication a pour statut <em>Publi&eacute;</em>, elle rapporte <b>15 points</b> suppl&eacute;mentaires</li>
                <li><u>Around the world</u> : Si la publication appartient &agrave; une cat&eacute;gorie <em>internationale</em>, elle rapporte <b>15 points</b> suppl&eacute;mentaires</li>
                <li><u>Chauvin</u> : Si la publication date de <em>1994</em> (fondation de l'UTT), elle rapporte <b>25 points</b> suppl&eacute;mentaires</li>
                <li><u>Sociable</u> : Chaque collaborateur du chercheur rajoute <b>20 points</b></li>
                <li><u>Interculturel</u> : Chaque collaborateur <em>ext&eacute;rieur &agrave; l'&eacute;quipe d'origine du chercheur mais dans la m&ecirc;me organisation</em> rapporte <b>10 points</b> suppl&eacute;mentaires</li>
                <li><u>Cosmopolite</u> : Chaque collaborateur <em>ext&eacute;rieur &agrave; l'organisation d'origine du chercheur</em> rapporte <b>20 points</b> suppl&eacute;mentaires</li>
                <li><u>Pas de quoi &ecirc;tre fier</u> : Chaque collaborateur ayant lui-m&ecirc;me <em>plus de 20 collaborateurs</em> enl&egrave;ve <b>150 points</b></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var jqReady = function() {
    $('#admin_tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
};
</script>
