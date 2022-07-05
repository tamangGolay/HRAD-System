<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('subdivisionmaster', function (Blueprint $table) {

		$table->integer('SubDivisionId');
		$table->string('SubDivNameShort');
		$table->string('SubDivNameLong');
		$table->integer('SubDivHead');
		$table->integer('SubDivReportsToDivision');
		$table->integer('SubDivReportsToDepartment');
		$table->integer('SubDivReportsToService');
		$table->integer('SubDivReportsToCompany');
		$table->integer('SubDivReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('subdivisionmaster');
    }
}