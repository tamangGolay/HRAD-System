<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaincoatsizeTable extends Migration
{
    public function up()
    {
        Schema::create('raincoatsize', function (Blueprint $table) {

		$table->id();
		$table->string('sizeName');
		$table->integer('shouldersCm');
		$table->integer('chestCm');
		$table->integer('waistCm');
		$table->integer('bottomCm');
		$table->integer('lengthCm');
		$table->integer('sleeveCm');
		$table->string('gender');
		$table->string('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('raincoatsize');
    }
}