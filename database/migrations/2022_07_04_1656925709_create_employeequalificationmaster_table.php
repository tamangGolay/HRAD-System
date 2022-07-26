<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeequalificationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('employeequalificationmaster', function (Blueprint $table) {

		$table->id();
		$table->foreignId('personalNo')->references('id')->on('users');
        //$table->string('personalNo');
        $table->foreignId('qualificationId')->references('id')->on('qualificationmaster');
        $table->string('yearCompleted',4)->nullable();
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeequalificationmaster');
    }
}