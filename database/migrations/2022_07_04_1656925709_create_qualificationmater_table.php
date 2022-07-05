<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationmaterTable extends Migration
{
    public function up()
    {
        Schema::create('qualificationmater', function (Blueprint $table) {

		$table->integer('qualificationId');
		$table->string('qualificationName');
		$table->integer('qualificationLevel');
		$table->integer('yearOfcompletion');

        });
    }

    public function down()
    {
        Schema::dropIfExists('qualificationmater');
    }
}