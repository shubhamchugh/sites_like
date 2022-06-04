<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhoIsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('who_is_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->nullable()->unsigned();
            $table->text('text')->nullable();
            $table->string('whoisServer')->nullable();
            $table->json('nameServers')->nullable();
            $table->date('creationDate')->nullable();
            $table->date('expirationDate')->nullable();
            $table->date('updatedDate')->nullable();
            $table->json('states')->nullable();
            $table->string('owner')->nullable();
            $table->string('registrar')->nullable();
            $table->string('dnssec')->nullable();
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
        Schema::dropIfExists('who_is_records');
    }
}
