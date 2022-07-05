<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavehistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavehistorymaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('employeemaster');  //fk to master employee
		$table->date('applicationDate'); 
		$table->string('leaveType')->references('id')->on('leavetypemaster');   //fk md leave_type
        $table->date('from'); 
        $table->date('to'); 
        $table->integer('leavePeriod'); 
        $table->string('status'); 
        $table->string('remarks'); 
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavehistorymaster');
    }
}