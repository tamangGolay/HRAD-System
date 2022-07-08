<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitmasterTable extends Migration
{
    public function up()
    {
        Schema::create('unitmaster', function (Blueprint $table) {

		$table->id();
		$table->string('unitNameShort');
		$table->string('unitNameLong');
		$table->integer('unitHead');
		$table->integer('unitReportsToSubDivision')->nullable();
		$table->integer('unitReportsToDivision')->nullable();
		$table->integer('unitReportsToDepartment')->nullable();
		$table->integer('unitReportsToService')->nullable();
		$table->integer('unitReportsToCompany')->nullable();
		$table->integer('unitReportsToEmp')->nullable();
		$table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
        $table->timestamp('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unitmaster');
    }
}