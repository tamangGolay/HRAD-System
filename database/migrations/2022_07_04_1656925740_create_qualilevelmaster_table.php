<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualilevelmasterTable extends Migration
{
    public function up()
    {
        Schema::create('qualilevelmaster', function (Blueprint $table) {

		$table->integer('qualiLevelId');
		$table->string('qualiLevelName');

        });
    }

    public function down()
    {
        Schema::dropIfExists('qualilevelmaster');
    }
}