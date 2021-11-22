<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_parameter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('parameter_id')->constrained('parameters')->onUpdate('cascade')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('job_parameter');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
