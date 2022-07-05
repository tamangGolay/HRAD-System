<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitmasterTable extends Migration
{
    public function up()
    {
        Schema::create('unitmaster', function (Blueprint $table) {

		$table->integer('UnitId');
		$table->string('UnitNameShort');
		$table->string('UnitNameLong');
		$table->integer('UnitHead');
		$table->integer('UnitReportsToSubDivision');
		$table->integer('UnitReportsToDivision');
		$table->integer('UnitReportsToDepartment');
		$table->integer('UnitReportsToService');
		$table->integer('UnitReportsToCompany');
		$table->integer('UnitReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('unitmaster');
    }
}