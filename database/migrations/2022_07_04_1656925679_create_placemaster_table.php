<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacemasterTable extends Migration
{
    public function up()
    {
        Schema::create('placemaster', function (Blueprint $table) {

		$table->integer('PlaceId',5);
		$table->string('PlaceName',100);
		$table->integer('VillageId');
		$table->integer('TownId');

        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}