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
		// $table->foreignId('personalNo')->references('id')->on('employeemaster');
        $table->string('personalNo');
        $table->foreignId('qualificationId')->references('id')->on('qualificationmaster');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
        $table->timestamp('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeequalificationmaster');
    }
}