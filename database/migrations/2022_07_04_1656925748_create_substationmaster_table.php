<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('substationmaster', function (Blueprint $table) {

		$table->integer('ssId');
		$table->string('ssNameShort');
		$table->string('ssNameLong');
		$table->integer('ssHead');
		$table->integer('ssReportsToUnit');
		$table->integer('ssReportsToSubDivision');
		$table->integer('ssReportsToDivision');
		$table->integer('ssReportsToDepartment');
		$table->integer('ssReportsToService');
		$table->integer('ssReportsToCompany');
		$table->integer('ssReportsToEmp');
		$table->integer('createdBy');
		$table->timestamp('createdOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('substationmaster');
    }
}