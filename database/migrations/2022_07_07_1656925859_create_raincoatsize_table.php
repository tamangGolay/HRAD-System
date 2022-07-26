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
		$table->string('sizeName',10);
		$table->decimal('shouldersCm',6,2);
		$table->decimal('chestCm',6,2);
		$table->decimal('waistCm',6,2);
		$table->decimal('bottomCm',6,2);
		$table->decimal('lengthCm',6,2);
		$table->decimal('sleeveCm',6,2);
		$table->enum('gender', ['Male', 'Female','unisex', 'Other'])->default('unisex');
		$table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	

        });
    }

    public function down()
    {
        Schema::dropIfExists('raincoatsize');
    }
}