<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuteurPublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auteur_publication', function (Blueprint $table) {
            $table->integer('auteur_id');
            $table->integer('publication_id');
            $table->smallInteger('ordre');
            $table->primary(['auteur_id', 'publication_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auteur_publication');
    }
}
