<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDnsDetailsTableForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns_details', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('dns_details')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dns_details', function (Blueprint $table) {
            $table->dropForeign('dns_details_post_id_foreign');
        });
    }
}
