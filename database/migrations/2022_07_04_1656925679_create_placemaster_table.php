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
        $table->string('placeCategory',100);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);



        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}