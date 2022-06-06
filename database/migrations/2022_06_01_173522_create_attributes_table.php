<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->nullable()->unsigned();
            $table->string('alexa_rank')->nullable();
            $table->string('alexa_country')->index()->nullable();
            $table->string('alexa_country_code')->index()->nullable();
            $table->string('alexa_country_rank')->nullable();
            $table->string('sitejabber_ranking')->nullable();
            $table->string('trustpilot_ranking')->nullable();
            $table->string('zoutons_ranking')->nullable();
            $table->string('mywot_ranking')->nullable();
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
        Schema::dropIfExists('attributes');
    }
}
