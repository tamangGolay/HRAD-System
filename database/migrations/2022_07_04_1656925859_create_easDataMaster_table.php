<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateeasdatamasterTable extends Migration
{
    public function up()
    {
        Schema::create('easdatamaster', function (Blueprint $table) {

		$table->integer('personalNo');  //fk to master employee
		$table->integer('year'); //fk to master employee
		$table->integer('rating'); //fk to master employee

        });
    }

    public function down()
    {
        Schema::dropIfExists('easdatamaster');
    }
}