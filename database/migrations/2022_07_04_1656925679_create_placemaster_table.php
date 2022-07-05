<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacemasterTable extends Migration
{
    public function up()
    {
        Schema::create('placemaster', function (Blueprint $table) {

		$table->integer('PlaceId');
		$table->string('PlaceName');
		$table->string('Dzongkhag');
        $table->string('Drungkhag');
        $table->string('Gewog');
        $table->string('Village');


        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}