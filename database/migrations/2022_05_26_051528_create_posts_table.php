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
            $table->string('status')->default('unpublish');
            $table->string('post_type', 50)->default('listing');
            $table->string('up_down')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('favicon')->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('page_views')->default('0');
            $table->boolean('is_index_google')->index()->default('0');
            $table->boolean('is_index_bing')->index()->default('0');
            $table->string('is_wappalyzer')->index()->default('pending');
            $table->string('is_ssl')->index()->default('pending');
            $table->string('is_alexa')->index()->default('pending');
            $table->string('is_seo_analyzer')->index()->default('pending');
            $table->string('is_whois')->index()->default('pending');
            $table->string('is_dns')->index()->default('pending');
            $table->string('is_ip_location')->index()->default('pending');
            $table->string('is_screenshot')->index()->default('pending');
            $table->softDeletes();
            $table->timestamps();
            $table->index('updated_at');
            $table->index('created_at');
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
