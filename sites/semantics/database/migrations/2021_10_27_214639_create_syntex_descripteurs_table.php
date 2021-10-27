<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntexDescripteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syntex_descripteurs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('doc_id');
            $table->integer('score');
            $table->integer('score_moy');
            $table->integer('freq');
            $table->integer('titre');
            $table->integer('longueur');
            $table->integer('longueur_num');
            $table->string('cat');
            $table->string('category_name');
            $table->string('lemme');
            $table->string('forme');
            $table->integer('rang');
            $table->float('freq_pond');
            $table->timestamps();

            $table->unique(['uuid', 'doc_id', 'lemme']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syntex_descripteurs');
    }
}
