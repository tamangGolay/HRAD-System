<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeemasterTable extends Migration
{
    public function up()
    {
        Schema::create('employeemaster', function (Blueprint $table) {
		$table->id(); 
		$table->integer('empId');
		$table->string('empName');
		$table->string('bloodGroup')->nullable();
		$table->bigInteger('cidNo');
		$table->string('cidOther')->nullable();
		$table->date('dob');
		$table->string('gender');
		$table->date('appointmentDate');
        $table->foreignId('gradeId')->references('id')->on('grademaster')->nullable();
		$table->foreignId('designationId')->references('id')->on('designationmaster')->nullable();//fk md_designation N
		$table->foreignId('office')->references('id')->on('officename')->nullable();
		$table->integer('basicPay')->nullable();
		$table->string('empStatus')->nullable();
		$table->date('lastDop')->nullable();
		$table->integer('mobileNo')->nullable();
		$table->string('emailId')->nullable();
	    $table->foreignId('placeId')->references('id')->on('placemaster')->nullable();
		$table->foreignId('bankName')->references('id')->on('bankmaster')->nullable();
		$table->string('accountNumber')->nullable();
	    $table->foreignId('resignationTypeId')->references('id')->on('resignationtypemaster')->nullable();
		$table->date('resignationDate')->nullable(); 
		$table->string('employmentType')->nullable(); //frontEnd dropdown html
		$table->string('incrementCycle')->nullable();
		$table->string('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
		$table->date('updated_at');
		$table->date('created_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('employeemaster');
    }
}