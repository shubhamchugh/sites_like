<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->nullable()->unsigned();
            $table->text('A')->nullable();
            $table->text('AAAA')->nullable();
            $table->text('CNAME')->nullable();
            $table->text('NS')->nullable();
            $table->text('SOA')->nullable();
            $table->text('MX')->nullable();
            $table->text('SRV')->nullable();
            $table->text('TXT')->nullable();
            $table->text('DNSKEY')->nullable();
            $table->text('CAA')->nullable();
            $table->text('NAPTR')->nullable();
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
        Schema::dropIfExists('dns_details');
    }
}
