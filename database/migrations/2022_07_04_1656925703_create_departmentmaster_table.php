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
		$table->string('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->date('updated_at');
        $table->date('created_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('departmentmaster');
    }
}