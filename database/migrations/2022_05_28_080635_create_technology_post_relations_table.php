<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologyPostRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technology_post_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->unsigned()->index();
            $table->bigInteger('technology_id')->unsigned()->index();
            $table->string('confidence', 125)->index()->nullable();
            $table->string('version', 125)->index()->nullable();
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
        Schema::dropIfExists('technology_post_relations');
    }
}
