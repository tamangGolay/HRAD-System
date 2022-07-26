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
		$table->string('resignationType',100);
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
     
        });
    }

    public function down()
    {
        Schema::dropIfExists('resignationtypemaster');
    }
}