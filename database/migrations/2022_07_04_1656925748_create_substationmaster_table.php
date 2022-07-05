<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('substationmaster', function (Blueprint $table) {

		$table->integer('SSId');
		$table->string('SSNameShort');
		$table->string('SSNameLong');
		$table->integer('SSHead');
		$table->integer('SSReportsToUnit');
		$table->integer('SSReportsToSubDivision');
		$table->integer('SSReportsToDivision');
		$table->integer('SSReportsToDepartment');
		$table->integer('SSReportsToService');
		$table->integer('SSReportsToCompany');
		$table->integer('SSReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('substationmaster');
    }
}