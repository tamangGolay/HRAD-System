<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualilevelmasterTable extends Migration
{
    public function up()
    {
        Schema::create('qualilevelmaster', function (Blueprint $table) {

		$table->id();
		$table->string('qualiLevelName');

        });
    }

    public function down()
    {
        Schema::dropIfExists('qualilevelmaster');
    }
}