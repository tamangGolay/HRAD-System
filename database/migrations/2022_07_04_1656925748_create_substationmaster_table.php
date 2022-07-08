<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('substationmaster', function (Blueprint $table) {

		$table->id();
		$table->string('ssNameShort');
		$table->string('ssNameLong');
		$table->integer('ssHead')->nullable();
		$table->integer('ssReportsToUnit')->nullable();
		$table->integer('ssReportsToSubDivision')->nullable();
		$table->integer('ssReportsToDivision')->nullable();
		$table->integer('ssReportsToDepartment')->nullable();
		$table->integer('ssReportsToService')->nullable();
		$table->integer('ssReportsToCompany')->nullable();
		$table->integer('ssReportsToEmp')->nullable();
		$table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('substationmaster');
    }
}