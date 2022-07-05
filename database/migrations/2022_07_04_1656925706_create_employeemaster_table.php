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
		$table->integer('designation');//fk md_designation N
		$table->foreignId('office')->references('OfficeId')->on('officemaster');
		$table->integer('basicPay');
		$table->string('empStatus');
		$table->date('lastDop');
		$table->integer('mobileNo');
		$table->string('emailId');
		$table->string('placeId');//fk md_placemaster N
		$table->string('bankName');//fk md_bankmaster N
		$table->string('accountNumber');
		$table->string('resignationType'); //fk md_resignation_Type_Master N
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