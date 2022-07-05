<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGewogmasterTable extends Migration
{
    public function up()
    {
        Schema::create('gewogmaster', function (Blueprint $table) {

		$table->integer('GewogId');
		$table->string('GewogName');
		$table->integer('Drungkhag');
		$table->integer('Dzongkhag');

        });
    }

    public function down()
    {
        Schema::dropIfExists('gewogmaster');
    }
}