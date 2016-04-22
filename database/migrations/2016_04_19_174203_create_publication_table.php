<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre');
            $table->string('reference');
            $table->date('annee');
            $table->string('lieu')->nullable();
            $table->string('document');
            $table->integer('statut_id')->index();
            $table->integer('categorie_id')->index();
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
        Schema::drop('publication');
    }
}
