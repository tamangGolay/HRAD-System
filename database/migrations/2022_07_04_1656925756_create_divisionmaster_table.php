<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('divisionmaster', function (Blueprint $table) {

		$table->integer('divisionId');
		$table->string('divNameShort');
		$table->string('divNameLong');
		$table->integer('divHead');
		$table->integer('divReportsToDepartment');
		$table->integer('divReportsToService');
		$table->integer('divReportsToCompany');
		$table->integer('divReportsToEmp');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('divisionmaster');
    }
}