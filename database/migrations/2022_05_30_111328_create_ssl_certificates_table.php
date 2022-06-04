<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSslCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssl_certificates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->nullable()->unsigned();
            $table->string('issuer')->index()->nullable();
            $table->string('getSignatureAlgorithm')->index()->nullable();
            $table->string('getOrganization')->index()->nullable();
            $table->json('getAdditionalDomains')->nullable();
            $table->string('getFingerprint')->nullable();
            $table->string('getFingerprintSha256')->nullable();
            $table->dateTime('validFromDate')->nullable();
            $table->dateTime('expirationDate')->nullable();
            $table->string('isValid')->nullable();
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
        Schema::dropIfExists('ssl_certificates');
    }
}
