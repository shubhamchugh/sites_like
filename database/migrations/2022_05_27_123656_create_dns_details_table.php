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
            $table->string('A')->nullable();
            $table->string('AAAA')->nullable();
            $table->string('CNAME')->nullable();
            $table->string('NS')->nullable();
            $table->string('SOA')->nullable();
            $table->string('MX')->nullable();
            $table->string('SRV')->nullable();
            $table->string('TXT')->nullable();
            $table->string('DNSKEY')->nullable();
            $table->string('CAA')->nullable();
            $table->string('NAPTR')->nullable();
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
