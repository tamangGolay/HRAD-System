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
		$table->string('PlaceName');
		$table->foreignId('Dzongkhag')->references('id')->on('dzongkhagmaster');
        $table->string('Drungkhag');
        $table->foreignId('Gewog')->references('id')->on('gewogmaster');
        $table->string('Village');



        });
    }

    public function down()
    {
        Schema::dropIfExists('placemaster');
    }
}