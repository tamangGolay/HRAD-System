<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavebalancemasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavebalancemaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('employeemaster');  //fk to master employee
		$table->integer('casualLeaveBalance'); 
		$table->integer('earnedLeaveBalance'); 
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavebalancemaster');
    }
}