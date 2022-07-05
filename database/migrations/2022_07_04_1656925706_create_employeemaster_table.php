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
		$table->string('bloodGroup');
		$table->bigInteger('cidNo');
		$table->date('dob');
		$table->string('gender');
		$table->date('appointmentDate');
        $table->foreignId('grade')->references('id')->on('grademaster');
		$table->integer('designation')->references('id')->on('designationmaster'); ;//fk md_designation N
		$table->foreignId('office')->references('id')->on('officemaster');
		$table->integer('basicPay');
		$table->string('empStatus');
		$table->date('lastDop');
		$table->integer('mobileNo');
		$table->string('emailId');
		$table->foreignId('placeId')->references('id')->on('placemaster');
		$table->string('bankName');//fk md_bankmaster N
		$table->string('accountNumber');
		// $table->foreignId('resignationType')->references('id')->on('resignationtypemaster');
		$table->date('resignationDate'); 
		$table->string('employmentType'); //frontEnd dropdown html
		$table->string('incrementCycle');

        });
    }

    public function down()
    {
        Schema::dropIfExists('employeemaster');
    }
}