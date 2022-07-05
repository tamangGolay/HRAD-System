<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentmasterTable extends Migration
{
    public function up()
    {
        Schema::create('departmentmaster', function (Blueprint $table) {

		$table->id();
		$table->string('deptNameShort');
		$table->string('deptNameLong');
		$table->integer('deptHead');
		$table->integer('deptReportsToService');
		$table->integer('deptReportsToCompany');
		$table->integer('deptReportsToEmp');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('departmentmaster');
    }
}