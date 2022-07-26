<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateeasdatamasterTable extends Migration
{
    public function up()
    {
        Schema::create('easdatamaster', function (Blueprint $table) {
		$table->foreignId('personalNo') ->references('id')->on('users'); //fk to master employee
		$table->string('year',4); //fk to master employee
		$table->tinyInteger('rating'); //fk to master employee
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('easdatamaster');
    }
}