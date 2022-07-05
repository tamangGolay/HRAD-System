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
		$table->integer('EmpId');
		$table->string('EmpName');
		$table->string('BloodGroup');
		$table->bigInteger('CIDNo');
		$table->date('DOB');
		$table->string('Gender');
		$table->date('AppointmentDate');
        $table->foreignId('Grade')->references('id')->on('grademaster');
		$table->integer('Designation');//fk md_designation N
		$table->foreignId('Office')->references('OfficeId')->on('officemaster');
		$table->integer('BasicPay');
		$table->string('EmpStatus');
		$table->date('LastDoP');
		$table->integer('MobileNo');
		$table->string('EmailId');
		$table->string('placeId');//fk md_placemaster N
		$table->string('bankName');//fk md_bankmaster N
		$table->string('resignationType'); //fk md_resignation_Type_Master N
		$table->date('resignationDate'); 
		$table->string('employmentType'); //frontEnd dropdown html
		$table->string('IncrementCycle');

        });
    }

    public function down()
    {
        Schema::dropIfExists('employeemaster');
    }
}