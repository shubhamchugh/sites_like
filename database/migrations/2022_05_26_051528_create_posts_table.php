<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->index()->nullable();
            $table->string('slug')->unique();
            $table->string('ip')->index()->nullable();
            $table->string('status')->index()->default('unpublish');
            $table->string('post_type', 50)->default('listing');
            $table->string('language')->nullable();
            $table->string('load_time')->nullable();
            $table->string('up_down')->nullable();
            $table->string('image')->index()->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_index_google')->index()->default('0');
            $table->boolean('is_index_bing')->index()->default('0');
            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
