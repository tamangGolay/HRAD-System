<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagemasterTable extends Migration
{
    public function up()
    {
        Schema::create('villagemaster', function (Blueprint $table) {

		$table->integer('VillageId');
		$table->string('VillageName');
		$table->integer('Gewog');

        });
    }

    public function down()
    {
        Schema::dropIfExists('villagemaster');
    }
}