<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('divisionmaster', function (Blueprint $table) {

		$table->integer('DivisionId');
		$table->string('DivNameShort');
		$table->string('DivNameLong');
		$table->integer('DivHead');
		$table->integer('DivReportsToDepartment');
		$table->integer('DivReportsToService');
		$table->integer('DivReportsToCompany');
		$table->integer('DivReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('divisionmaster');
    }
}