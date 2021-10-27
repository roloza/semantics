<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntexAuditInclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syntex_audit_incls', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('num_1');
            $table->integer('num_2');
            $table->timestamps();

            $table->unique(['uuid', 'num_1', 'num_2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syntex_audit_incls');
    }
}
