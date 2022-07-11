<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacemasterTable extends Migration
{
    public function up()
    {
        Schema::create('placemaster', function (Blueprint $table) {

		$table->id();
        $table->foreignId('villageId')->references('id')->on('villagemaster');
        $table->foreignId('townId')->references('id')->on('townmaster');
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhags');
        $table->foreignId('drungkhagId')->references('id')->on('drungkhagmaster');
        $table->foreignId('gewogId')->references('id')->on('gewogmaster');
        $table->string('placeCategory');
        $table->timestamp('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->timestamp('modifiedBy')->nullable();
		$table->timestamp('modifiedOn')->nullable();
        $table->integer('status')->default(0);



        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}