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
		$table->string('placeName');
		$table->foreignId('dzongkhag')->references('id')->on('dzongkhags');
        $table->string('drungkhag');
        $table->foreignId('gewog')->references('id')->on('gewogmaster');
        $table->string('village');
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->integer('status')->default(0);



        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}