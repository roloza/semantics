<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_links', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->foreignId('url_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('link');
            $table->string('text');
            $table->string('title');
            $table->string('target');
            $table->string('rel');
            $table->boolean('isNoFollow');
            $table->string('type');
            $table->integer('count');
            $table->timestamps();

            $table->unique(['uuid', 'url', 'link'], 'uul');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_links');
    }
}
