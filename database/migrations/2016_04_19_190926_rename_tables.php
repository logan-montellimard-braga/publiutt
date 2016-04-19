<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('auteur', 'auteurs');
        Schema::rename('equipe', 'equipes');
        Schema::rename('organisation', 'organisations');
        Schema::rename('statut', 'statuts');
        Schema::rename('categorie', 'categories');
        Schema::rename('publication', 'publications');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('auteurs', 'auteur');
        Schema::rename('equipes', 'equipe');
        Schema::rename('organisations', 'organisation');
        Schema::rename('statuts', 'statut');
        Schema::rename('categories', 'categorie');
        Schema::rename('publications', 'publication');
    }
}
