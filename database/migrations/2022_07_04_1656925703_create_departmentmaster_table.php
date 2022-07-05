<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentmasterTable extends Migration
{
    public function up()
    {
        Schema::create('departmentmaster', function (Blueprint $table) {

		$table->integer('DepartmentId');
		$table->string('DeptNameShort');
		$table->string('DeptNameLong');
		$table->integer('DeptHead');
		$table->integer('DeptReportsToService');
		$table->integer('DeptReportsToCompany');
		$table->integer('DeptReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('departmentmaster');
    }
}