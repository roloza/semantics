<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntexRtListesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syntex_rt_listes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('num');
            $table->string('cat');
            $table->string('category_name');
            $table->string('lemme');
            $table->string('forme');
            $table->integer('freq');
            $table->integer('nb_doc');
            $table->integer('frequisol');
            $table->integer('nincl');
            $table->integer('longueur');
            $table->timestamps();

            $table->unique(['uuid', 'num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syntex_rt_listes');
    }
}
