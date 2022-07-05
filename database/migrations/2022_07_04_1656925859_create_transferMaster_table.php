<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetransfermasterTable extends Migration
{
    public function up()
    {
        Schema::create('transfermaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('employeemaster');   //fk md employee master
		$table->date('transferDate');
        $table->string('transferFrom')->references('id')->on('officemaster'); //fk md officeMaster
        $table->string('transferTo');
        $table->date('status');
        $table->string('remarks');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfermaster');
    }
}