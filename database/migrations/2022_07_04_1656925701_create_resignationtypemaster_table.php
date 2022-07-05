<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResignationtypemasterTable extends Migration
{
    public function up()
    {
        Schema::create('resignationtypemaster', function (Blueprint $table) {

		$table->id();
		$table->string('resignationType');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
     
        });
    }

    public function down()
    {
        Schema::dropIfExists('resignationtypemaster');
    }
}