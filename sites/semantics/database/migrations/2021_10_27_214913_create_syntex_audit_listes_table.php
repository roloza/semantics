<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntexAuditListesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syntex_audit_listes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('num');
            $table->string('cat');
            $table->string('category_name');
            $table->string('lemme');
            $table->integer('longueur_num');
            $table->integer('longueur');
            $table->float('score');
            $table->integer('freq_num');
            $table->integer('nbincl1_num');
            $table->integer('nbdoc_num');
            $table->integer('nbdec_num');
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
        Schema::dropIfExists('syntex_audit_listes');
    }
}
