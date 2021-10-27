<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntexAuditDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syntex_audit_descs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('doc_id');
            $table->integer('num');
            $table->integer('longueur');
            $table->integer('score');
            $table->integer('score_moy');
            $table->integer('freq_doc');
            $table->string('forme');
            $table->timestamps();

            $table->unique(['uuid', 'doc_id', 'num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syntex_audit_descs');
    }
}
