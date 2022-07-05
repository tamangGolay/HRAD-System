<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacemasterTable extends Migration
{
    public function up()
    {
        Schema::create('placemaster', function (Blueprint $table) {

		$table->integer('placeId',5);
		$table->string('placeName',100);
		$table->integer('villageId');
		$table->integer('townId');

        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}