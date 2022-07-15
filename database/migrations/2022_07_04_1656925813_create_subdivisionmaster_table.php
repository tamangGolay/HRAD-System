<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('subdivisionmaster', function (Blueprint $table) {

		$table->id();
		$table->string('subDivnameShort');
		$table->string('subDivnameLong');
		$table->foreignId('subDivhead')->references('id')->on('users');
		$table->foreignId('subDivreportsTodivision')->references('id')->on('divisionmaster');
		$table->integer('subDivreportsTodepartment');
		$table->integer('subDivreportsToservice');
		$table->integer('subDivreportsTocompany');
		$table->integer('subDivreportsToEmp');
		$table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('subdivisionmaster');
    }
}