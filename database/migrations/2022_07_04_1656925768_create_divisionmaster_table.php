<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('divisionmaster', function (Blueprint $table) {

		$table->id();
		$table->string('divNameShort');
		$table->string('divNameLong');
		$table->foreignId('divDzoId')->references('id')->on('dzongkhags');		
		$table->foreignId('divHead')->references('id')->on('employeemaster');		
		$table->foreignId('divReportsToDepartment')->references('id')->on('departmentmaster')->nullable();
		$table->foreignId('deptDzoId')->references('id')->on('dzongkhags')->nullable();
		$table->foreignId('divReportsToService')->references('id')->on('servicemaster')->nullable();
		$table->foreignId('serviceDzoId')->references('id')->on('dzongkhags');
		$table->foreignId('divReportsToCompany')->references('id')->on('companymaster')->nullable();
		$table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
		

        });
    }

    public function down()
    {
        Schema::dropIfExists('divisionmaster');
    }
}