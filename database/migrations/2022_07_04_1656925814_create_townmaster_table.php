<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownmasterTable extends Migration
{
    public function up()
    {
        Schema::create('townmaster', function (Blueprint $table) {

		$table->integer('TownId');
		$table->string('TownName');
		$table->integer('GewogId');

        });
    }

    public function down()
    {
        Schema::dropIfExists('townmaster');
    }
}