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
		$table->integer('divHead')->nullable();
		$table->integer('divReportsToDepartment')->nullable();
		$table->integer('divReportsToService')->nullable();
		$table->integer('divReportsToCompany')->nullable();
		$table->integer('divReportsToEmp')->nullable();
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