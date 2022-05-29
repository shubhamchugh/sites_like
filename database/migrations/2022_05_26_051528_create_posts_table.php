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
            $table->boolean('status')->index()->default('1');
            $table->boolean('is_index_google')->index()->default('0');
            $table->boolean('is_index_bing')->index()->default('0');
            $table->string('post_type', 50)->default('listing');
            $table->string('domain_title')->index()->nullable();
            $table->string('domain_description')->index()->nullable();
            $table->string('image')->index()->nullable();
            $table->text('content')->nullable();
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
