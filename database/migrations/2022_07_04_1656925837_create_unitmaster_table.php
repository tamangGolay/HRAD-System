<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitmasterTable extends Migration
{
    public function up()
    {
        Schema::create('unitmaster', function (Blueprint $table) {

		$table->integer('unitId');
		$table->string('unitNameShort');
		$table->string('unitNameLong');
		$table->integer('unitHead');
		$table->integer('unitReportsToSubDivision');
		$table->integer('unitReportsToDivision');
		$table->integer('unitReportsToDepartment');
		$table->integer('unitReportsToService');
		$table->integer('unitReportsToCompany');
		$table->integer('unitReportsToEmp');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('unitmaster');
    }
}