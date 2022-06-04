<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoAnalyzersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_analyzers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->nullable()->unsigned();
            $table->string('language')->nullable();
            $table->string('loadtime')->nullable();
            $table->string('codeToTxtRatio')->nullable();
            $table->string('word_count')->nullable();
            $table->json('keywords')->nullable();
            $table->json('longTailKeywords')->nullable();
            $table->json('headers')->nullable();
            $table->json('links')->nullable();
            $table->json('images')->nullable();
            $table->string('domain_title')->index()->nullable();
            $table->string('domain_description')->index()->nullable();
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
        Schema::dropIfExists('seo_analyzers');
    }
}
