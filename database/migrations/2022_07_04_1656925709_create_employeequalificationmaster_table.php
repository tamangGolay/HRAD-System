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
		$table->string('personalNo')->references('id')->on('employeemaster');;
        $table->string('qualificationId')->references('id')->on('qualificationmaster');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeequalificationmaster');
    }
}