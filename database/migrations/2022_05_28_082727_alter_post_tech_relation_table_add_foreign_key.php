<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPostTechRelationTableAddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technology_post_relations', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technology_post_relations', function (Blueprint $table) {
            $table->dropForeign('technology_post_relations_post_id_foreign');
            $table->dropForeign('technology_post_relations_technology_id_foreign');
        });
    }
}
