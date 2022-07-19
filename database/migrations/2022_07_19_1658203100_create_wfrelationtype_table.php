<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfrelationtypeTable extends Migration
{
    public function up()
    {
        Schema::create('wfrelationtype', function (Blueprint $table) {

		$table->integer('relationId',2);
		$table->string('relationName',30);
		$table->string('verification',40);

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrelationtype');
    }
}