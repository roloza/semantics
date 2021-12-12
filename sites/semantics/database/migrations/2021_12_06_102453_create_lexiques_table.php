<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLexiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lexiques', function (Blueprint $table) {
            $table->id();
            $table->string('forme')->index();
            $table->string('lemme')->index();
            $table->string('phon');
            $table->string('cat_gram');
            $table->string('genre');
            $table->string('nombre');
            $table->integer('freq1');
            $table->integer('freq2');
            $table->integer('nb_leters');
            $table->integer('nb_phons');
            $table->integer('nb_syllables');
            $table->string('cv_cv');
            $table->integer('def_lem');
            $table->timestamps();

            $table->unique(['forme', 'lemme', 'cat_gram']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lexiques');
    }
}
