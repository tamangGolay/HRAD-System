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
        $table->string('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
     
        });
    }

    public function down()
    {
        Schema::dropIfExists('resignationtypemaster');
    }
}